<?php

namespace Bubblehearth\Bubblehearth\Classic\Models;

use Bubblehearth\Bubblehearth\Models\Links;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * A list of realms returned by the realms index endpoint.
 */
final readonly class RealmsIndex
{
    public function __construct(
        #[SerializedName('_links')]
        public Links $links,
        /**
         * @var array<Realm>
         */
        public array $realms
    ) {
    }
}
