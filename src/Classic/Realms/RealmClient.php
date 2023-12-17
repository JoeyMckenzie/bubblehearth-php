<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\BubbleHearthClient;
use Bubblehearth\Bubblehearth\Models\SearchResults;
use GuzzleHttp\Exception\GuzzleException;

/**
 * A client connector for the various realm endpoints and APIs.
 */
final readonly class RealmClient
{
    /**
     * @var string Subdomain associated to the account region.
     */
    private string $regionSubdomain;

    public function __construct(private BubbleHearthClient $internalClient)
    {
        $this->regionSubdomain = $this->internalClient->accountRegion->value;
    }

    /**
     * Retrieves a list of all realms and their associated metadata.
     *
     * @throws GuzzleException
     */
    public function getRealmIndex(): RealmsIndex
    {
        $url = "https://$this->regionSubdomain.api.blizzard.com/data/wow/realm/index";

        /** @var RealmsIndex $response */
        $response = $this->internalClient->sendAndDeserialize($url, RealmsIndex::class);

        return $response;
    }

    /**
     * Retrieves a realm given the slugified version of the name.
     *
     * @param  string  $realmSlug realm slug based on the name.
     *
     * @throws GuzzleException
     */
    public function getRealm(string $realmSlug): Realm
    {
        $url = "https://$this->regionSubdomain.api.blizzard.com/data/wow/realm/$realmSlug";

        /** @var Realm $response */
        $response = $this->internalClient->sendAndDeserialize($url, Realm::class);

        return $response;
    }

    /**
     * Searches for realms with optionally provided query parameters.
     *
     * @param  string  $timezone timezone of the realm. (example search field)
     * @param  string  $orderBy field to sort the result set by.
     * @param  int  $offset result page number
     * @return SearchResults<Realm> realms from the search.
     *
     * @throws GuzzleException
     */
    public function searchRealms(string $timezone = '', string $orderBy = '', int $offset = 0, int $page = 1): SearchResults
    {
        $url = "https://$this->regionSubdomain.api.blizzard.com/data/wow/search/realm";
        $queryParams = [
            'offset' => $offset,
            'page' => $page,
        ];

        if (! empty($timezone)) {
            $queryParams[] = ['timezone' => $timezone];
        }

        if (! empty($orderBy)) {
            $queryParams[] = ['orderBy' => $orderBy];
        }

        /** @var SearchResults<Realm> $response */
        $response = $this->internalClient->sendAndDeserialize($url, SearchResults::class, $queryParams);

        return $response;
    }
}
