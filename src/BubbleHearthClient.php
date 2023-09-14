<?php

declare(strict_types=1);

namespace Joeymckenzie\Bubblehearth;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Joeymckenzie\Bubblehearth\Provider\OAuthProvider;

/**
 * A top-level client for interacting with Blizzard Game Data APIs.
 */
readonly class BubbleHearthClient
{
    private OAuthProvider $provider;

    /**
     * @param  string  $clientId registered client ID provided by Blizzard.
     * @param  string  $clientSecret registered client secret provided by Blizzard.
     */
    public function __construct(protected string $clientId, protected string $clientSecret)
    {
        $this->provider = new OAuthProvider($this->clientId, $this->clientSecret);
    }

    /**
     * Runs a request for obtaining GitHub user data.
     */
    public function run(): void
    {
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
