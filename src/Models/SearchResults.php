<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

/**
 * A generic search result class for search endpoints and APIs.
 *
 * @template T search result data type.
 */
abstract class SearchResults
{
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
     * @var SearchResultItem<T>[] search results generic over a type.
     */
    public array $results;
}
