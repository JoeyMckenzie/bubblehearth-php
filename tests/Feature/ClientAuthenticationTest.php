<?php

declare(strict_types=1);

namespace Feature;

use Joeymckenzie\Bubblehearth\AccountRegion;
use Joeymckenzie\Bubblehearth\BubbleHearthClient;

test('returns an access token when requested', function () {
    // Arrange
    $clientId = (string) getenv('CLIENT_ID');
    $clientSecret = (string) getenv('CLIENT_SECRET');
    $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US);

    // Act
    $response = $client->getAccessToken();

    // Assert
    expect($response)
        ->not
        ->toBeNull()
        ->and(true)
        ->toBeTrue();
});
