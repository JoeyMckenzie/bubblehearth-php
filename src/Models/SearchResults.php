<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

use Bubblehearth\Bubblehearth\Classic\Realms\RealmSearchResults;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

/**
 * A generic search result class for search endpoints and APIs.
 *
 * @template T search result data type.
 */
#[DiscriminatorMap(typeProperty: 'type', mapping: [
    'realms' => RealmSearchResults::class,
])]
abstract class SearchResults
{
    public string $type;

    /**
     * @var int current page of the search results.
     */
    public int $page;

    /**
     * @var int count of the current page's result.
     */
    public int $pageSize;

    /**
     * @var int max page count limit;
     */
    public int $maxPageSize;

    /**
     * @var int total number of pages of search results.
     */
    public int $pageCount;

    /**
     * @var SearchResultItem<T>[] a generic search result item containing the model specific search data.
     */
    public array $results;
}
