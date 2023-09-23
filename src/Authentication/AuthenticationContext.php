<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Authentication;

use Bubblehearth\Bubblehearth\AccountRegion;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\Serializer;

/**
 * Represents the authentication response context.
 */
final class AuthenticationContext
{
    /**
     * @var string|null access token returned from client credentials authentication.
     */
    private ?string $accessToken;

    /**
     * @var DateTime|null internally tracked expiration date/time of the current access token.
     */
    private ?DateTime $expiresAt;

    public function __construct(
        private readonly Client $client,
        private readonly Serializer $serializer,
        private readonly AccountRegion $region,
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly int $timeoutSeconds)
    {
        $this->accessToken = null;
        $this->expiresAt = null;
    }

    /**
     * Requests a raw access token for authenticating against all client requests.
     * Upon retrieval, access tokens are cached within client unless explicitly flushed.
     *
     * @param  bool  $forceRefresh flag indicating to force override the current token with the one returned from the request.
     * @return string access token.
     *
     * @throws GuzzleException
     */
    public function getAccessToken(bool $forceRefresh = false): string
    {
        if (! $forceRefresh && ! is_null($this->accessToken) && ! $this->refreshRequired()) {
            return $this->accessToken;
        }

        $response = $this->client->post($this->region->getTokenEndpoint(), [
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
        $authResponse = $this->serializer->deserialize($body, AuthenticationResponse::class, 'json');
        $this->accessToken = $authResponse->accessToken;

        return $this->accessToken;
    }

    /**
     * Checks the current expiration of the access token to determine if a new one is needed.
     *
     * @return bool true, if the refresh is needed.
     */
    public function refreshRequired(): bool
    {
        return $this->expiresAt < new DateTime();
    }
}
