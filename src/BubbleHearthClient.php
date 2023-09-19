<?php

declare(strict_types=1);

namespace Joeymckenzie\Bubblehearth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Default HTTP timeout, can be overridden when building the client.
 */
const DEFAULT_TIMEOUT_SECONDS = 5;

/**
 * A top-level client for interacting with Blizzard Game Data APIs.
 */
final class BubbleHearthClient
{
    /**
     * @var Client internal Guzzle instance used for all API requests.
     */
    private readonly Client $client;

    /**
     * @var AuthenticationContext|null optionally available authentication context, temporarily cached for access token reuse.
     */
    private ?AuthenticationContext $authentication = null;

    /**
     * @var Serializer internal serializer for marshalling objects.
     */
    private Serializer $serializer;

    /**
     * @param  string  $clientId registered client ID provided by Blizzard.
     * @param  string  $clientSecret registered client secret provided by Blizzard.
     * @param  AccountRegion  $accountRegion region the client should target for API calls.
     */
    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly AccountRegion $accountRegion,
        protected readonly int $timeoutSeconds = DEFAULT_TIMEOUT_SECONDS)
    {
        $this->client = new Client();
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader());
        $normalizer = new ObjectNormalizer($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $this->serializer = new Serializer([$normalizer], [new JsonEncoder()]);
    }

    /**
     * Retrieves an access token from Blizzard, caching for reuse of other downstream calls.
     * Prior to calling Blizzard to retrieve a token, we'll check for an existing token and
     * use the one if found in the current context unless refresh is required.
     *
     * @return string access token.
     *
     * @throws GuzzleException
     */
    public function getAccessToken(bool $forceRefresh = false): string
    {
        if (! $forceRefresh && ! is_null($this->authentication?->accessToken) && ! $this->authentication->refreshRequired()) {
            return $this->authentication->accessToken;
        }

        $response = $this->client->post($this->accountRegion->getTokenEndpoint(), [
            'auth' => [$this->clientId, $this->clientSecret],
            'multipart' => [
                [
                    'name' => 'grant_type',
                    'contents' => 'client_credentials',
                ],
            ],
            'timeout' => $this->timeoutSeconds,
        ]);

        $body = $response->getBody()->getContents();
        $this->authentication = $this->serializer->deserialize($body, AuthenticationContext::class, 'json');

        return $this->authentication->accessToken;
    }
}
