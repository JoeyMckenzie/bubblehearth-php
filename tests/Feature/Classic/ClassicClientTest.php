<?php

declare(strict_types=1);

namespace Feature;

use Bubblehearth\Bubblehearth\AccountRegion;
use Bubblehearth\Bubblehearth\BubbleHearthClient;
use Bubblehearth\Bubblehearth\Locale;

describe('realms', function () {
    test('returns a list of realms from the index endpoint', function () {
        // Arrange
        $clientId = (string) getenv('CLIENT_ID');
        $clientSecret = (string) getenv('CLIENT_SECRET');
        $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US, Locale::EnglishUS);

        // Act
        $realms = $client
            ->classic()
            ->realms()
            ->getRealmIndex();

        // Assert
        expect($realms)
            ->not->toBeNull()
            ->and($realms->realms)->not->toBeEmpty()
            ->and($realms->realms[0]->name)->not()->toBeNull()
            ->and($realms->realms[0]->region)->toBeNull();
    });

    test('returns a single locale for realms when locale is provided', function () {
        // Arrange
        $clientId = (string) getenv('CLIENT_ID');
        $clientSecret = (string) getenv('CLIENT_SECRET');
        $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US, Locale::EnglishUS);

        // Act
        $realms = $client
            ->classic()
            ->realms()
            ->getRealmIndex();

        // Assert
        expect($realms)
            ->not->toBeNull()
            ->and($realms->realms)->not->toBeEmpty()
            ->and($realms->realms[0]->name)->toBeString()
            ->and($realms->realms[0]->region)->toBeNull();
    });

    test('returns a single locale for a realm when locale is provided', function () {
        // Arrange
        $clientId = (string) getenv('CLIENT_ID');
        $clientSecret = (string) getenv('CLIENT_SECRET');
        $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US, Locale::EnglishUS);

        // Act
        $realm = $client
            ->classic()
            ->realms()
            ->getRealm('grobbulus');

        // Assert
        expect($realm)->not->toBeNull()
            ->and($realm->slug)->toBe('grobbulus')
            ->and($realm->key)->toBeNull()
            ->and($realm->id)->not->toBeNull()
            ->and($realm->region)->not->toBeNull()
            ->and($realm->name)->toBeString();
    });

    test('returns paginated results for a realm search', function () {
        // Arrange
        $clientId = (string) getenv('CLIENT_ID');
        $clientSecret = (string) getenv('CLIENT_SECRET');
        $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US, Locale::EnglishUS);

        // Act
        $realms = $client
            ->classic()
            ->realms()
            ->searchRealms();

        // Assert
        expect($realms)->not->toBeNull();
    });

    test('returns paginated results for a realm search when query parameters are provided', function () {
        // Arrange
        $clientId = (string) getenv('CLIENT_ID');
        $clientSecret = (string) getenv('CLIENT_SECRET');
        $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US, Locale::EnglishUS);

        // Act
        $realms = $client
            ->classic()
            ->realms()
            ->searchRealms(page: 2);

        // Assert
        expect($realms)->not->toBeNull()
            ->and($realms->results)->toBeGreaterThan(10);
    });
});
