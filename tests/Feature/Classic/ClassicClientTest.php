<?php

declare(strict_types=1);

namespace Feature;

use Bubblehearth\Bubblehearth\AccountRegion;
use Bubblehearth\Bubblehearth\BubbleHearthClient;
use Bubblehearth\Bubblehearth\Classic\Models\RealmLocale;
use Bubblehearth\Bubblehearth\Locale;

test('returns a list of realms from the index endpoint', function () {
    // Arrange
    $clientId = (string) getenv('CLIENT_ID');
    $clientSecret = (string) getenv('CLIENT_SECRET');
    $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US);

    // Act
    $realms = $client->classic->getRealmIndex();

    // Assert
    expect($realms)
        ->not->toBeNull()
        ->and($realms->realms)->not->toBeEmpty();
});

test('returns a single locale for realms when locale is provided', function () {
    // Arrange
    $clientId = (string) getenv('CLIENT_ID');
    $clientSecret = (string) getenv('CLIENT_SECRET');
    $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US);

    // Act
    $realms = $client->classic->getRealmIndex(Locale::EnglishUS);

    // Assert
    expect($realms)
        ->not->toBeNull()
        ->and($realms->realms)->not->toBeEmpty()
        ->and($realms->realms[0]->name)->toBeString();
});

test('returns a all locales for realms when locale is not provided', function () {
    // Arrange
    $clientId = (string) getenv('CLIENT_ID');
    $clientSecret = (string) getenv('CLIENT_SECRET');
    $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US);

    // Act
    $realms = $client->classic->getRealmIndex();

    // Assert
    expect($realms)
        ->not->toBeNull()
        ->and($realms->realms)->not->toBeEmpty()
        ->and($realms->realms[0]->name)->toBeObject();
});

test('returns a single locale for a realm when locale is provided', function () {
    // Arrange
    $clientId = (string) getenv('CLIENT_ID');
    $clientSecret = (string) getenv('CLIENT_SECRET');
    $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US);

    // Act
    $realm = $client->classic->getRealm('grobbulus', Locale::EnglishUS);

    // Assert
    expect($realm)
        ->not->toBeNull();
});

test('returns all locales for a realm when locale is not provided', function () {
    // Arrange
    $clientId = (string) getenv('CLIENT_ID');
    $clientSecret = (string) getenv('CLIENT_SECRET');
    $client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US);

    // Act
    $realm = $client->classic->getRealm('grobbulus');

    // Assert
    expect($realm)->not->toBeNull()
        ->and($realm->slug)->toBe('grobbulus')
        ->and($realm->name)->toBeInstanceOf(RealmLocale::class);
});
