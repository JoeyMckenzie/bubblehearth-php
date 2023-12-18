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
    public function __construct(private BubbleHearthClient $internalClient)
    {
    }

    public function realms(): RealmClient
    {
        return new RealmClient($this->internalClient);
    }
}
