<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\Models\SearchResults;

final class RealmSearchResults extends SearchResults
{
    /**
     * @var RealmSearchResultItem[] realm data associated with the search criteria.
     */
    public array $results;
}
