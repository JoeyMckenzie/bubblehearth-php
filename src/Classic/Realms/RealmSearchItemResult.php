<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\Models\SearchResultItem;

class RealmSearchItemResult extends SearchResultItem
{
    /**
     * @var Realm data returned from the search.
     */
    public Realm $data;
}
