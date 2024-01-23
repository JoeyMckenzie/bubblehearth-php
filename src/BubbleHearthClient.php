<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

use Bubblehearth\Bubblehearth\Authentication\AuthenticationResponse;
use Bubblehearth\Bubblehearth\Classic\ClassicClient;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
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
     * Base URL for the Blizzard API. We'll programmatically
     * update this to the proper subdomain when requests are made.
     */
    private const string BASE_URL = 'https://[region].api.blizzard.com';

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
     * @var Carbon|null internally tracked expiration date/time of the current access token.
     */
    private ?Carbon $expiresAt;

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
        $this->expiresAt = null;
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
            new PhpStanExtractor(),
        ]);

        $normalizers = [
            new BackedEnumNormalizer(),
            new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, $extractor),
            new ArrayDenormalizer(),
        ];

        return new Serializer($normalizers, ['json' => new JsonEncoder()]);
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
     * @param  string  $uri  target Game Data API URI.
     * @param  string  $type  target type to deserialize into.
     * @param  string|null  $typeMapping  assumes a generic search result model type.
     * @param  array<string, string|int>|null  $query  optional query parameters.
     * @param  bool  $includeLocale  flag for indicating if the locale should be included in the query parameters, defaults to true.
     *
     * @throws GuzzleException
     */
    public function sendAndDeserialize(string $uri, string $type, ?string $typeMapping = null, ?array $query = null, bool $includeLocale = true): mixed
    {
        $response = self::sendRequest($uri, $query, $includeLocale);
        $body = $response->getBody()->getContents();

        // Okay... this feels stupid but seems to be the only solution
        // to generic serialization with Syfmfony. We need to manually
        // append the $typeMapping property to the generic search result
        // model AND the search result item types. Then, we'll encode it
        // back to JSON so Symfony can use the discriminator class mapping
        // to make the determination of which instances of the search result
        // class to deserialize to. There's gotta be a better way, this'll do for now
        if (isset($typeMapping)) {
            $data = json_decode($body, true);

            // @phpstan-ignore-next-line
            $data['type'] = $typeMapping;

            // @phpstan-ignore-next-line
            foreach ($data['results'] as &$result) {
                // @phpstan-ignore-next-line
                $result['type'] = $typeMapping;
            }

            $body = json_encode($data);
        }

        return $this->serializer->deserialize($body, $type, 'json');
    }

    /**
     * Sends a request to Blizzard, used by all child client connectors.
     * Requests can include optional query parameters in which, if they
     * are included, will be merged with the default locale included on
     * each request. Internally, we'll point to the correct subdomain
     * based on the account region, so adapters need only to pass the endpoint.
     *
     * @param  string  $uri  target Game Data API URI.
     * @param  array<string, string|int>|null  $query  optional query parameters.
     * @param  bool  $includeLocale  flag for indicating if the locale should be included in the query parameters, defaults to true.
     *
     * @throws GuzzleException
     */
    public function sendRequest(string $uri, ?array $query = null, bool $includeLocale = true): ResponseInterface
    {
        $token = self::getAccessToken();
        $region = $this->accountRegion->value;
        $requestOptions = [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Battlenet-Namespace' => "dynamic-classic-$region",
            ],
        ];

        $queryParams = $includeLocale ?
            [
                'locale' => $this->locale->value,
            ] : [];

        if (isset($query)) {
            $queryParams = array_merge($queryParams, $query);
        }

        $requestOptions['query'] = $queryParams;
        $baseUrl = str_replace('[region]', $this->accountRegion->value, self::BASE_URL);
        $url = $baseUrl.'/'.$uri;

        return $this->client->get($url, $requestOptions);
    }

    /**
     * Requests a raw access token for authenticating against all client requests.
     * Upon retrieval, access tokens are cached within client unless explicitly flushed.
     *
     * @return string access token.
     *
     * @throws GuzzleException
     */
    private function getAccessToken(): string
    {
        $tokenRefreshRequired = ! is_null($this->expiresAt) && $this->expiresAt < Carbon::now();

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
        $this->expiresAt = Carbon::now()->addSeconds($authResponse->expiresIn);

        return $this->accessToken;
    }
}
