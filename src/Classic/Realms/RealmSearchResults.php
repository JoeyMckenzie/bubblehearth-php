<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\Models\SearchResults;

final class RealmSearchResults extends SearchResults
{
    /**
     * @var RealmSearchItemResult[] search results generic over a type.
     */
    public array $results;
}
