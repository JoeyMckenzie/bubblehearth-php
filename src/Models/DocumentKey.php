<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

/**
 * Represents the key to a document, usually in the form of a static URL.
 */
final readonly class DocumentKey
{
    /**
     * @var string document key, URL.
     */
    public string $href;

    public function __construct(string $href)
    {
        $this->href = $href;
    }
}
