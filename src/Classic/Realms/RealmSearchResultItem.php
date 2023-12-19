<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\Models\SearchResultItem;

/**
 * @extends SearchResultItem<Realm>
 */
final class RealmSearchResultItem extends SearchResultItem
{
    /**
     * @var Realm realm search result.
     */
    public Realm $data;
}
