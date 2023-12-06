<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic;

use Bubblehearth\Bubblehearth\AccountRegion;
use Bubblehearth\Bubblehearth\Authentication\AuthenticationContext;
use Bubblehearth\Bubblehearth\Classic\Realms\RealmClient;
use Bubblehearth\Bubblehearth\Locale;
use GuzzleHttp\Client;
use Symfony\Component\Serializer\Serializer;

/**
 * A client for WoW Classic, utilizing the base client authentication.
 */
final readonly class ClassicClient
{
    /**
     * @var RealmClient client connector for realm data.
     */
    private RealmClient $realms;

    public function __construct(
        Client $http,
        AccountRegion $region,
        Locale $locale,
        AuthenticationContext $authentication,
        Serializer $serializer)
    {
        $this->realms = new RealmClient($http, $region, $locale, $authentication, $serializer);
    }

    public function realms(): RealmClient
    {
        return $this->realms;
    }
}
