<?php

declare(strict_types=1);

namespace Feature;

use Bubblehearth\Bubblehearth\AccountRegion;
use Bubblehearth\Bubblehearth\BubbleHearthClient;
use Bubblehearth\Bubblehearth\Classic\Regions\Region;
use Bubblehearth\Bubblehearth\Locale;

describe('regions', function () {
    test('returns a list of regions from the index endpoint', function () {
        // Arrange
        $clientId = (string) getenv('CLIENT_ID');
        $clientSecret = (string) getenv('CLIENT_SECRET');
        $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US, Locale::EnglishUS);

        // Act
        $regions = $client
            ->classic()
            ->regions()
            ->getRegionIndex();

        // Assert
        expect($regions)->not->toBeNull()
            ->and($regions->links)->not->toBeNull();
        collect($regions->regions)->each(fn (Region $region) => expect($region)
            ->not()->toBeNull());
    });
});
