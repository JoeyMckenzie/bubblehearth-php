<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

/**
 * A generic search result item containing both key and the relevant search data.
 *
 * @template T generic search type returned from results.
 */
final readonly class SearchResultItem
{
    /**
     * @param  DocumentKey  $key search item document key, URL.
     * @param  T  $data resulting collection data.
     */
    public function __construct(public DocumentKey $key, public mixed $data)
    {
    }
}
