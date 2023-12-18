<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

/**
 * A generic search result item containing both key and the relevant search data.
 */
class SearchResultItem
{
    /**
     * @var DocumentKey search item document key, URL.
     */
    public DocumentKey $key;
}
