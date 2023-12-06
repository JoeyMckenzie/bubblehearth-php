<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\Models\DocumentKey;
use Bubblehearth\Bubblehearth\Models\Links;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Realm metadata for all available World of Warcraft Classic servers.
 */
final readonly class Realm
{
    /**
     * @var string slugified realm name.
     */
    public string $slug;

    /**
     * @var int realm ID.
     */
    public int $id;

    /**
     * @var Links|null top-level document link to follow of the selected realm ID
     */
    #[SerializedName('_links')]
    public ?Links $links;

    /**
     * @var DocumentKey|null document key for the realm, defaults to the URL.
     */
    public ?DocumentKey $key;

    /**
     * @var string localized realm name.
     */
    public string $name;

    /**
     * @var RealmRegion|null realm region, including document links.
     */
    public ?RealmRegion $region;

    /**
     * @var bool|null optional flag representing if the realm is a PVP tournament realm.
     */
    public ?bool $isTournament;

    /**
     * @var string|null optional timezone.
     */
    public ?string $timezone;

    public function __construct(
        string $slug,
        int $id,
        ?Links $links,
        ?DocumentKey $key,
        string $name,
        ?RealmRegion $region,
        ?bool $isTournament)
    {
        $this->slug = $slug;
        $this->id = $id;
        $this->links = $links;
        $this->key = $key;
        $this->name = $name;
        $this->region = $region;
        $this->isTournament = $isTournament;
    }
}
