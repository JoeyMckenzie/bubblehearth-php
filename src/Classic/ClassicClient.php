<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic;

use Bubblehearth\Bubblehearth\AccountRegion;
use Bubblehearth\Bubblehearth\Authentication\AuthenticationContext;
use Bubblehearth\Bubblehearth\Classic\Models\Realm;
use Bubblehearth\Bubblehearth\Classic\Models\RealmsIndex;
use Bubblehearth\Bubblehearth\Locale;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\Serializer;

/**
 * A client for WoW Classic, utilizing the base client authentication.
 */
final readonly class ClassicClient
{
    /**
     * @param  Client  $http internal Guzzle client, configured for timeout and other defaults.
     * @param  AccountRegion  $region configured account region.
     * @param  AuthenticationContext  $authentication internally cached authentication context, allowing for token reuse and smart refreshing.
     * @param  Serializer  $serializer global Symfony serializer configured for Bubblehearth.
     */
    public function __construct(
        private Client $http,
        private AccountRegion $region,
        private AuthenticationContext $authentication,
        private Serializer $serializer)
    {
    }

    /**
     * Retrieves a list of all realms and their associated metadata.
     *
     * @param  Locale|null  $locale targeted locale.
     *
     * @throws GuzzleException
     */
    public function getRealmIndex(Locale $locale = null): RealmsIndex
    {
        $regionSubdomain = $this->region->value;
        $url = "https://$regionSubdomain.api.blizzard.com/data/wow/realm/index";

        if (isset($locale)) {
            $url = "$url?locale=$locale->value";
        }

        $token = $this->authentication->getAccessToken();
        $headers = ['Authorization' => "Bearer $token", 'Battlenet-Namespace' => "dynamic-classic-$regionSubdomain"];
        $response = $this->http->get($url, [
            'headers' => $headers,
        ]);

        return $this->serializer->deserialize($response->getBody()->getContents(), RealmsIndex::class, 'json');
    }

    /**
     * Retrieves a realm given the slugified version of the name.
     *
     * @param  string  $realmSlug realm slug based on the name.
     * @param  Locale|null  $locale targeted locale.
     *
     * @throws GuzzleException
     */
    public function getRealm(string $realmSlug, Locale $locale = null): Realm
    {
        $regionSubdomain = $this->region->value;
        $url = "https://$regionSubdomain.api.blizzard.com/data/wow/realm/$realmSlug";

        if (isset($locale)) {
            $url = "$url?locale=$locale->value";
        }

        $token = $this->authentication->getAccessToken();
        $headers = ['Authorization' => "Bearer $token", 'Battlenet-Namespace' => "dynamic-classic-$regionSubdomain"];
        $response = $this->http->get($url, [
            'headers' => $headers,
        ]);

        return $this->serializer->deserialize($response->getBody()->getContents(), Realm::class, 'json');
    }
}
