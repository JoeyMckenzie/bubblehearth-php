<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

/**
 * A generic search result class for search endpoints and APIs.
 *
 * @template T search result data type.
 */
final readonly class SearchResults
{
    /**
     * @var int current page of the search results.
     */
    public int $page;

    /**
     * @var int|null count of the current page's result.
     */
    public ?int $pageSize;

    /**
     * @var int|null max page count limit;
     */
    public ?int $maxPageSize;

    /**
     * @var int|null total number of pages of search results.
     */
    public ?int $pageCount;

    /**
     * @var SearchResultItem<T>[] search results generic over a type.
     */
    public array $results;

    /**
     * @param  SearchResultItem<T>[]  $results
     */
    public function __construct(
        int $page,
        ?int $pageSize,
        ?int $maxPageSize,
        ?int $pageCount,
        array $results)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->maxPageSize = $maxPageSize;
        $this->pageCount = $pageCount;
        $this->results = $results;
    }
}
