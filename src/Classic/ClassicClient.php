<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic;

use Bubblehearth\Bubblehearth\BubbleHearthClient;
use Bubblehearth\Bubblehearth\Classic\Realms\RealmClient;

/**
 * A client for WoW Classic, utilizing the base client authentication.
 */
final readonly class ClassicClient
{
    /**
     * @var RealmClient client connector for realm data.
     */
    private RealmClient $realms;

    public function __construct(BubbleHearthClient $internalClient)
    {
        $this->realms = new RealmClient($internalClient);
    }

    public function realms(): RealmClient
    {
        return $this->realms;
    }
}
