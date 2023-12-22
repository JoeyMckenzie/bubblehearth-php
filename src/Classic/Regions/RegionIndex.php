<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Regions;

use Bubblehearth\Bubblehearth\Models\Links;
use Symfony\Component\Serializer\Annotation\SerializedName;

final class RegionIndex
{
    /**
     * @var Links op-level document link to follow for a selected region ID.
     */
    #[SerializedName('_links')]
    public Links $links;

    /**
     * @var Region[] list of regions available for the current locale.
     */
    public array $regions;
}
