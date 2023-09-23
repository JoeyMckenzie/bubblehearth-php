<?php

namespace Bubblehearth\Bubblehearth\Classic\Models;

use Bubblehearth\Bubblehearth\Models\DocumentKey;

/**
 * Realm metadata for all available World of Warcraft Classic servers.
 */
final readonly class Realm
{
    public function __construct(
        public DocumentKey $key,
        public int $id,
        public string $slug,
        /**
         * @var string|RealmLocale
         */
        public mixed $name,
    ) {
    }
}
