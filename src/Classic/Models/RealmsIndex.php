<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Models;

use Bubblehearth\Bubblehearth\Models\Links;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * A list of realms returned by the realms index endpoint.
 */
final readonly class RealmsIndex
{
    /**
     * @param  Links  $links top-level document link to follow for a selected realm ID.
     * @param  array<Realm>  $realms list of available realms and their metadata.
     */
    public function __construct(
        #[SerializedName('_links')]
        public Links $links,
        public array $realms
    ) {
    }
}
