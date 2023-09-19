<?php

declare(strict_types=1);

namespace Joeymckenzie\Bubblehearth\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * A top-level client for interacting with Blizzard Game Data APIs.
 */
final readonly class InternalClient
{
    /**
     * @var Client internal Guzzle client for making API requests to Blizzard.
     */
    private Client $client;

    /**
     * @param  string  $clientId registered client ID provided by Blizzard.
     * @param  string  $clientSecret registered client secret provided by Blizzard.
     */
    public function __construct(private string $clientId, private string $clientSecret, private ?string $baseUri = null, private ?float $timeoutSeconds = null)
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri ?? '',
            'timeout' => $this->timeoutSeconds ?? DEFAULT_TIMEOUT,
        ]);
    }

    /**
     * Requests a client access token to be used for Game Data APIs using client credentials provided by the developer portal.
     *
     * @throws GuzzleException
     */
    public function getAccessToken(): string
    {
        $clientCredentials = base64_encode($this->clientId.':'.$this->clientId);
        $requestOptions = [
            'headers' => [
                'Basic' => $clientCredentials,
            ],
            'multipart' => [
                'grant_type' => 'client_credentials',
            ],
        ];

        $response = $this->client->postAsync(OAuthEndpoints::GLOBAL_TOKEN_ENDPOINT, [
            'headers' => [
                'Basic' => $clientCredentials,
            ],
            'multipart' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        return '';
    }

    public function getAccessTokenAsync($resolve): string
    {
        $clientCredentials = base64_encode($this->clientId.':'.$this->clientId);
        $response = $this->client->postAsync(OAuthEndpoints::GLOBAL_TOKEN_ENDPOINT, [
            'headers' => [
                'Basic' => $clientCredentials,
            ],
            'multipart' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        return '';
    }

    /**
     * Runs a request for obtaining GitHub user data.
     */
    public function run(): void
    {
        $this->provider->getClient();
        $client = new Client();
        //$res = $client->request('GET', 'https://api.github.com/user', [
        //    'auth' => ['user', 'pass']
        //]);
        //echo $res->getStatusCode();

        // "200"
        //echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        //echo $res->getBody();
        // {"type":"User"...'

        // Send an asynchronous request.
        $request = new Request('GET', 'http://httpbin.org');
        $promise = $client->sendAsync($request)->then(fn (Response $response) => $response->getBody());
        $promise->wait();
    }
}
