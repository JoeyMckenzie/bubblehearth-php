<?php

namespace Joeymckenzie\Bubblehearth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

/**
 * A top-level client for interacting with Blizzard Game Data APIs.
 */
readonly class BubbleHearthClient
{
    public function __construct(protected string $clientId, protected string $clientSecret)
    {
    }

    /**
     * Runs a request for obtaining GitHub user data.
     *
     * @throws GuzzleException
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
        $promise = $client->sendAsync($request)->then(function ($response) {
            echo 'I completed! '.$response->getBody();
        });
        $promise->wait();
    }
}
