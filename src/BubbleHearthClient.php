<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

use Bubblehearth\Bubblehearth\Authentication\AuthenticationResponse;
use Bubblehearth\Bubblehearth\Classic\ClassicClient;
use DateInterval;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * A top-level client for interacting with Blizzard Game Data APIs.
 */
final class BubbleHearthClient
{
    /**
     * Default HTTP timeout, can be overridden when building the client.
     */
    private const int DEFAULT_TIMEOUT_SECONDS = 5;

    /**
     * @var string required client ID.
     */
    public readonly string $clientId;

    /**
     * @var string required client secret.
     */
    public readonly string $clientSecret;

    /**
     * @var AccountRegion required client account region.
     */
    public readonly AccountRegion $accountRegion;

    /**
     * @var Locale required client region locale.
     */
    public readonly Locale $locale;

    /**
     * @var Client internal Guzzle client.
     */
    private readonly Client $client;

    /**
     * @var Serializer internal serializer for marshalling responses from the Blizzard API.
     */
    private readonly Serializer $serializer;

    /**
     * @var string|null access token returned from client credentials authentication.
     */
    private ?string $accessToken;

    /**
     * @var DateTime|null internally tracked expiration date/time of the current access token.
     */
    private ?DateTime $expiresAt;

    public function __construct(
        string $clientId,
        string $clientSecret,
        AccountRegion $accountRegion,
        Locale $locale,
        int $timeoutSeconds = self::DEFAULT_TIMEOUT_SECONDS)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->accountRegion = $accountRegion;
        $this->locale = $locale;
        $this->client = new Client(['timeout' => $timeoutSeconds]);
        $this->serializer = self::initializeSerializer();
        $this->expiresAt = new DateTime('now');
        $this->accessToken = null;
    }

    /**
     * Initializes a new Symfony serializer to marshal responses from the Game Data APIs.
     *
     * @return Serializer Symfony serializer.
     */
    private function initializeSerializer(): Serializer
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $extractor = new PropertyInfoExtractor([], [
            new PhpDocExtractor(),
            new ReflectionExtractor(),
        ]);
        $normalizer = new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, $extractor);

        return new Serializer([$normalizer, new ArrayDenormalizer()], [new JsonEncoder()]);
    }

    /**
     * @return ClassicClient a classic client instance for interacting with WoW Classic APIs.
     */
    public function classic(): ClassicClient
    {
        return new ClassicClient($this);
    }

    /**
     * Sends a request to Blizzard and attempts to
     * deserialize the response into the target type.
     *
     *
     * @param  string  $url target Game Data API URL.
     * @param  string  $type target type to deserialize into.
     * @param  array<string, string|int>|null  $query optional query parameters.
     *
     * @throws GuzzleException
     */
    public function sendAndDeserialize(string $url, string $type, ?array $query = null): mixed
    {
        $response = self::sendRequest($url, $query);
        $body = $response->getBody()->getContents();

        return $this->serializer->deserialize($body, $type, 'json');
    }

    /**
     * Sends a request to Blizzard, used by all child client connectors.
     *
     * @param  string  $url target Game Data API URL.
     * @param  array<string, string|int>|null  $query optional query parameters.
     *
     * @throws GuzzleException
     */
    public function sendRequest(string $url, ?array $query = null): ResponseInterface
    {
        $token = self::getAccessToken();
        $region = $this->accountRegion->value;
        $requestOptions = [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Battlenet-Namespace' => "dynamic-classic-$region",
            ],
        ];

        $queryParams = [
            'locale' => $this->locale->value,
        ];

        if (isset($query)) {
            $queryParams = array_merge($queryParams, $query);
        }

        $requestOptions['query'] = $queryParams;

        return $this->client->get($url, $requestOptions);
    }

    /**
     * Requests a raw access token for authenticating against all client requests.
     * Upon retrieval, access tokens are cached within client unless explicitly flushed.
     *
     * @return string access token.
     *
     * @throws GuzzleException
     * @throws Exception
     */
    private function getAccessToken(): string
    {
        $tokenRefreshRequired = ! is_null($this->expiresAt) && $this->expiresAt < new DateTime();

        if (! is_null($this->accessToken) && ! $tokenRefreshRequired) {
            return $this->accessToken;
        }

        $response = $this->client->post($this->accountRegion->getTokenEndpoint(), [
            'auth' => [$this->clientId, $this->clientSecret],
            'multipart' => [
                [
                    'name' => 'grant_type',
                    'contents' => 'client_credentials',
                ],
            ],
        ]);

        $body = $response->getBody()->getContents();
        $authResponse = $this->serializer->deserialize($body, AuthenticationResponse::class, 'json');
        $this->accessToken = $authResponse->accessToken;
        $this->expiresAt = new DateTime();
        $interval = new DateInterval('PT'.$authResponse->expiresIn.'S');
        $this->expiresAt->add($interval);

        return $this->accessToken;
    }
}
