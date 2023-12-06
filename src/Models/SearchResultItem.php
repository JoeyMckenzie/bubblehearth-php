<?php

namespace Bubblehearth\Bubblehearth\Models;

/**
 * A generic search result item containing both key and the relevant search data.
 *
 * @template T
 */
final readonly class SearchResultItem
{
    /**
     * @var DocumentKey search item document key, URL.
     */
    public DocumentKey $key;

    /**
     * @var T generic search result data.
     */
    public mixed $data;

    public function __construct(DocumentKey $key, mixed $data)
    {
        $this->key = $key;
        $this->data = $data;
    }
}
