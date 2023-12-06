<?php

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\AccountRegion;
use Bubblehearth\Bubblehearth\Authentication\AuthenticationContext;
use Bubblehearth\Bubblehearth\Locale;
use Bubblehearth\Bubblehearth\Models\SearchResults;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\Serializer;

/**
 * A client connector for the various realm endpoints and APIs.
 */
final readonly class RealmClient
{
    /**
     * @var Serializer global Symfony serializer configured for Bubblehearth.
     */
    private Serializer $serializer;

    /**
     * @var AuthenticationContext internally cached authentication context, allowing for token reuse and smart refreshing.
     */
    private AuthenticationContext $authentication;

    /**
     * @var AccountRegion configured account region.
     */
    private AccountRegion $region;

    /**
     * @var Locale configured locale.
     */
    private Locale $locale;

    /**
     * @var Client internal Guzzle client, configured for timeout and other defaults.
     */
    private Client $http;

    public function __construct(
        Client $http,
        AccountRegion $region,
        Locale $locale,
        AuthenticationContext $authentication,
        Serializer $serializer)
    {
        $this->http = $http;
        $this->region = $region;
        $this->locale = $locale;
        $this->authentication = $authentication;
        $this->serializer = $serializer;
    }

    /**
     * Retrieves a list of all realms and their associated metadata.
     *
     * @throws GuzzleException
     */
    public function getRealmIndex(): RealmsIndex
    {
        $regionSubdomain = $this->region->value;
        $url = "https://$regionSubdomain.api.blizzard.com/data/wow/realm/index";
        $token = $this->authentication->getAccessToken();
        $headers = ['Authorization' => "Bearer $token", 'Battlenet-Namespace' => "dynamic-classic-$regionSubdomain"];
        $response = $this->http->get($url, [
            'headers' => $headers,
            'query' => ['locale' => $this->locale->value],
        ]);

        return $this->serializer->deserialize($response->getBody()->getContents(), RealmsIndex::class, 'json');
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
        $regionSubdomain = $this->region->value;
        $url = "https://$regionSubdomain.api.blizzard.com/data/wow/realm/$realmSlug";
        $token = $this->authentication->getAccessToken();
        $headers = ['Authorization' => "Bearer $token", 'Battlenet-Namespace' => "dynamic-classic-$regionSubdomain"];
        $response = $this->http->get($url, [
            'headers' => $headers,
            'query' => ['locale' => $this->locale->value],
        ]);

        return $this->serializer->deserialize($response->getBody()->getContents(), Realm::class, 'json');
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
    public function searchRealms(string $timezone = '', string $orderBy = '', int $offset = 1): SearchResults
    {
        $regionSubdomain = $this->region->value;
        $url = "https://$regionSubdomain.api.blizzard.com/data/wow/search/realm";

        $token = $this->authentication->getAccessToken();
        $headers = ['Authorization' => "Bearer $token", 'Battlenet-Namespace' => "dynamic-classic-$regionSubdomain"];
        $queryParams = ['offset' => $offset];

        if (! empty($timezone)) {
            $queryParams[] = ['timezone' => $timezone];
        }

        if (! empty($orderBy)) {
            $queryParams[] = ['orderBy' => $orderBy];
        }

        $response = $this->http->get($url, [
            'headers' => $headers,
            // 'query' => $queryParams,
        ]);

        $body = $response->getBody()->getContents();

        return $this->serializer->deserialize($response->getBody()->getContents(), SearchResults::class, 'json');
    }
}
