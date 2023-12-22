<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Regions;

use Bubblehearth\Bubblehearth\Models\Links;
use Symfony\Component\Serializer\Attribute\SerializedName;

final class Region
{
    /**
     * @var Links op-level document link to follow for a selected region ID.
     */
    #[SerializedName('_links')]
    public Links $links;

    /**
     * @var int ID of the region.
     */
    public int $id;

    /**
     * @var string Localized name of the region.
     */
    public string $name;

    /**
     * @var string Tag of the region, represented as with a country code.
     */
    public string $tag;
}
