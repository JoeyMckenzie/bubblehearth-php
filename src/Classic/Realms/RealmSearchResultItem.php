<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\Models\SearchResultItem;

final class RealmSearchResultItem extends SearchResultItem
{
    /**
     * @var Realm associated realm data on the search item.
     */
    public Realm $data;
}
