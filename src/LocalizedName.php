<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

/**
 * Name localities for a specific item.
 */
final readonly class LocalizedName
{
    /**
     * @var LocalizedItem container property for the various localities.
     */
    public LocalizedItem $name;

    public function __construct(LocalizedItem $name)
    {
        $this->name = $name;
    }
}
