<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

/**
 * Represents the key to a document, usually in the form of a static URL.
 */
final readonly class DocumentKey
{
    /**
     * @param  string  $href document key, URL.
     */
    public function __construct(public string $href)
    {
    }
}
