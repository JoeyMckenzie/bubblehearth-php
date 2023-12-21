<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

/**
 * Name localities for a specific item.
 */
final class LocalizedName
{
    /**
     * @var LocalizedItem container property for the various localities.
     */
    public LocalizedItem $name;

    /**
     * @var string|null type associated with the name.
     */
    public ?string $type;
}
