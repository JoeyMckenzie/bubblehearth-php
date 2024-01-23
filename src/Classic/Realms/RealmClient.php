<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\BubbleHearthClient;
use Bubblehearth\Bubblehearth\Timezone;
use GuzzleHttp\Exception\GuzzleException;

/**
 * A client connector for the various realm endpoints and APIs.
 */
final readonly class RealmClient
{
    public function __construct(private BubbleHearthClient $internalClient)
    {
    }

    /**
     * Retrieves a list of all realms and their associated metadata.
     *
     * @throws GuzzleException
     */
    public function getRealmIndex(): RealmsIndex
    {
        $url = 'data/wow/realm/index';

        /** @var RealmsIndex $response */
        $response = $this->internalClient->sendAndDeserialize($url, RealmsIndex::class);

        return $response;
    }

    /**
     * Retrieves a realm given the slugified version of the name.
     *
     * @param  string  $realmSlug  realm slug based on the name.
     *
     * @throws GuzzleException
     */
    public function getRealm(string $realmSlug): Realm
    {
        $uri = "data/wow/realm/$realmSlug";

        /** @var Realm $response */
        $response = $this->internalClient->sendAndDeserialize($uri, Realm::class);

        return $response;
    }

    /**
     * Searches for realms with optionally provided query parameters.
     *
     * @param  Timezone|null  $timezone  timezone of the realm.
     * @param  string  $orderBy  field to sort the result set by.
     * @return RealmSearchResults realms from the search.
     *
     * @throws GuzzleException
     */
    public function searchRealms(?Timezone $timezone = null, string $orderBy = '', int $page = 1): RealmSearchResults
    {
        $uri = 'data/wow/search/realm';
        $queryParams = [
            '_page' => $page,
        ];

        if (! empty($timezone)) {
            $queryParams = array_merge(['timezone' => $timezone->value]);
        }

        if (! empty($orderBy)) {
            $queryParams = array_merge(['orderby' => $orderBy]);
        }

        /** @var RealmSearchResults $response */
        $response = $this->internalClient->sendAndDeserialize($uri, RealmSearchResults::class, query: $queryParams, includeLocale: false);

        return $response;
    }
}
