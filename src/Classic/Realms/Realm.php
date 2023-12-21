<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\LocalizedItem;
use Bubblehearth\Bubblehearth\LocalizedName;
use Bubblehearth\Bubblehearth\Models\DocumentKey;
use Bubblehearth\Bubblehearth\Models\Links;
use Bubblehearth\Bubblehearth\Timezone;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Realm metadata for all available World of Warcraft Classic servers.
 */
final class Realm
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
    public ?Links $links = null;

    /**
     * @var DocumentKey|null document key for the realm, defaults to the URL.
     */
    public ?DocumentKey $key = null;

    /**
     * @var string|LocalizedItem localized realm name.
     */
    public string|LocalizedItem $name;

    /**
     * @var string|LocalizedItem realm category including region and timezone.
     */
    public string|LocalizedItem $category;

    /**
     * @var RealmRegion|LocalizedName|null realm region, including document links.
     */
    public RealmRegion|LocalizedName|null $region;

    /**
     * @var bool|null optional flag representing if the realm is a PVP tournament realm.
     */
    public ?bool $isTournament;

    /**
     * @var Timezone|null optional timezone.
     */
    public ?Timezone $timezone;

    /**
     * @var RealmType|LocalizedName|null optional realm type.
     */
    public RealmType|LocalizedName|null $type = null;

    /**
     * @var ?DocumentKey key to mega server this realm is connected to.
     */
    public ?DocumentKey $connectedRealm;

    /**
     * @var ?string primary locale used for the realm.
     */
    public ?string $locale;
}
