<?php

declare(strict_types=1);

namespace Feature;

use Joeymckenzie\Bubblehearth\BubbleHearthClient;

test('client test', function () {
    $clientId = (string) getenv('CLIENT_ID');
    $clientSecret = (string) getenv('CLIENT_SECRET');
    $client = new BubbleHearthClient($clientId, $clientSecret);

    $client->run();

    expect(true)->toBeTrue();
});
