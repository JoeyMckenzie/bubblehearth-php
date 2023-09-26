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
     * @var int realm ID.
     */
    public int $id;

    /**
     * @var string slugified realm name.
     */
    public string $slug;

    /**
     * @var Links|null top-level document link to follow of the selected realm ID.
     */
    #[SerializedName('_links')]
    public ?Links $links;

    /**
     * @var DocumentKey|null document key for the realm, defaults to the URL.
     */
    public ?DocumentKey $key;

    /**
     * @var string|RealmLocale localized realm name.
     */
    public string|RealmLocale $name;

    public function __construct(int $id, string $slug, ?Links $links, ?DocumentKey $key, string|RealmLocale $name)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->links = $links;
        $this->key = $key;
        $this->name = $name;
    }
}
