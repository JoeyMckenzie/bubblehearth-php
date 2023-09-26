<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Models;

use Bubblehearth\Bubblehearth\Models\DocumentKey;
use Bubblehearth\Bubblehearth\Models\Links;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Realm metadata for all available World of Warcraft Classic servers.
 */
final readonly class Realm
{
    /**
     * @param  int  $id realm ID.
     * @param  string  $slug slugified realm name.
     * @param  Links|null  $links top-level document link to follow of the selected realm ID.
     * @param  DocumentKey|null  $key document key for the realm, defaults to the URL.
     * @param  string|RealmLocale  $name localized realm name.
     */
    public function __construct(
        public int $id,
        public string $slug,
        #[SerializedName('_links')]
        public ?Links $links,
        public ?DocumentKey $key,
        public string|RealmLocale $name)
    {
    }
}
