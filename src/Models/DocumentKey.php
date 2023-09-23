<?php

namespace Bubblehearth\Bubblehearth\Models;

/**
 * Represents the key to a document, usually in the form of a static URL.
 */
final readonly class DocumentKey
{
    public function __construct(
        /**
         * @var string document key, URL.
         */
        public string $href
    ) {
    }
}
