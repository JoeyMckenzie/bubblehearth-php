<?php

declare(strict_types=1);

namespace Feature;

use Bubblehearth\Bubblehearth\AccountRegion;
use Bubblehearth\Bubblehearth\BubbleHearthClient;
use Bubblehearth\Bubblehearth\Classic\Realms\Realm;
use Bubblehearth\Bubblehearth\Locale;
use Bubblehearth\Bubblehearth\Models\SearchResultItem;

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
        expect($realms)->not->toBeNull();
        collect($realms->realms)->each(fn (Realm $realm) => expect($realm)
            ->not()->toBeNull()
            ->and($realm->key)->not()->toBeNull()
            ->and($realm->key?->href)->not()->toBeNull()
            ->and($realm->id)->toBeGreaterThan(0)
            ->and($realm->name)->not()->toBeNull()
            ->and($realm->slug)->not()->toBeNull());
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
            ->and($realm->id)->toBeGreaterThan(0)
            ->and($realm->key)->toBeNull()
            ->and($realm->links)->not()->toBeNull()
            ->and($realm->links?->key)->not()->toBeNull()
            ->and($realm->links?->key?->href)->not()->toBeNull()
            ->and($realm->region)->not->toBeNull()
            ->and($realm->region?->name)->not->toBeNull()
            ->and($realm->region?->id)->not->toBeNull()
            ->and($realm->region?->key)->not->toBeNull()
            ->and($realm->region?->key?->href)->not->toBeNull()
            ->and($realm->connectedRealm)->not->toBeNull()
            ->and($realm->slug)->toBe('grobbulus')
            ->and($realm->name)->toBe('Grobbulus')
            ->and($realm->category)->toBe('US West')
            ->and($realm->timezone)->toBe('America/Los_Angeles')
            ->and($realm->type)->not()->toBeNull()
            ->and($realm->type?->type)->not()->toBeNull()
            ->and($realm->type?->name)->not()->toBeNull()
            ->and($realm->isTournament)->not()->toBeNull()
            ->and($realm->isTournament)->toBe(false);
    });

    test('returns paginated results for a realm search when no options are passed', function () {
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
        expect($realms)->not->toBeNull()
            ->and($realms->page)->toBe(1)
            ->and($realms->pageSize)->toBe(27)
            ->and($realms->maxPageSize)->toBe(100)
            ->and($realms->pageCount)->toBe(1);
        collect($realms->results)
            ->each(function (SearchResultItem $searchResult): void {
                /** @var Realm $realm */
                $realm = $searchResult->data;
                expect($searchResult)->not()->toBeNull()
                    ->and($realm)->not()->toBeNull()
                    ->and($realm->isTournament)->not()->toBeNull()
                    ->and($realm->timezone)->not()->toBeNull()
                    ->and($realm->name)->not()->toBeNull();
            });
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
