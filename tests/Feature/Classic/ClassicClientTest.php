<?php

declare(strict_types=1);

namespace Feature;

use Bubblehearth\Bubblehearth\AccountRegion;
use Bubblehearth\Bubblehearth\BubbleHearthClient;
use Bubblehearth\Bubblehearth\Classic\Realms\Realm;
use Bubblehearth\Bubblehearth\Classic\Realms\RealmRegion;
use Bubblehearth\Bubblehearth\Classic\Realms\RealmSearchResultItem;
use Bubblehearth\Bubblehearth\Classic\Realms\RealmType;
use Bubblehearth\Bubblehearth\Locale;
use Bubblehearth\Bubblehearth\LocalizedItem;
use Bubblehearth\Bubblehearth\LocalizedName;
use Bubblehearth\Bubblehearth\Timezone;

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

        /** @var RealmRegion $realmRegion */
        $realmRegion = $realm->region;

        /** @var RealmType $realmType */
        $realmType = $realm->type;

        // Assert
        expect($realm)->not->toBeNull()
            ->and($realm->id)->toBeGreaterThan(0)
            ->and($realm->key)->toBeNull()
            ->and($realm->links)->not()->toBeNull()
            ->and($realm->links?->key)->not()->toBeNull()
            ->and($realm->links?->key?->href)->not()->toBeNull()
            ->and($realm->region)->not->toBeNull()
            ->and($realm->region?->name)->not->toBeNull()
            ->and($realm->region?->name)->not->toBeNull()
            ->and($realmRegion->id)->not->toBeNull()
            ->and($realmRegion->key)->not->toBeNull()
            ->and($realm->region?->key?->href)->not->toBeNull()
            ->and($realm->connectedRealm)->not->toBeNull()
            ->and($realm->slug)->toBe('grobbulus')
            ->and($realm->name)->toBe('Grobbulus')
            ->and($realm->category)->toBe('US West')
            ->and($realm->timezone)->toBe(Timezone::AmericaLosAngeles)
            ->and($realm->type)->not()->toBeNull()
            ->and($realmType->type)->not()->toBeNull()
            ->and($realmType->name)->not()->toBeNull()
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
            ->each(fn (RealmSearchResultItem $realm) => expect($realm)->not()->toBeNull()
                ->and($realm->data)->not()->toBeNull()
                ->and($realm->data->id)->toBeGreaterThan(0)
                ->and($realm->data->isTournament)->toBeBool()
                ->and($realm->data->timezone)->toBeInstanceOf(Timezone::class)
                ->and($realm->data->slug)->toBeString()
                ->and($realm->data->name)->toBeInstanceOf(LocalizedItem::class)
                ->and($realm->data->region)->toBeInstanceOf(LocalizedName::class)
                ->and($realm->data->category)->toBeInstanceOf(LocalizedItem::class)
                ->and($realm->data->type)->toBeInstanceOf(LocalizedName::class)
                ->and($realm->data->locale)->toBeString());
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
            ->searchRealms(timezone: Timezone::AmericaLosAngeles);

        // Assert
        expect($realms)->not->toBeNull()
            ->and($realms->page)->toBe(1)
            ->and($realms->pageSize)->toBe(11)
            ->and($realms->maxPageSize)->toBe(100)
            ->and($realms->pageCount)->toBe(1);
        collect($realms->results)
            ->each(fn (RealmSearchResultItem $realm) => expect($realm)->not()->toBeNull()
                ->and($realm->data)->not()->toBeNull()
                ->and($realm->data->id)->toBeGreaterThan(0)
                ->and($realm->data->isTournament)->toBeBool()
                ->and($realm->data->timezone)->toBe(Timezone::AmericaLosAngeles)
                ->and($realm->data->slug)->toBeString()
                ->and($realm->data->name)->toBeInstanceOf(LocalizedItem::class)
                ->and($realm->data->region)->toBeInstanceOf(LocalizedName::class)
                ->and($realm->data->category)->toBeInstanceOf(LocalizedItem::class)
                ->and($realm->data->type)->toBeInstanceOf(LocalizedName::class)
                ->and($realm->data->locale)->toBeString());
    });
});
