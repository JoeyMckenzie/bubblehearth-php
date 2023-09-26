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
     * @var array<Realm> list of available realms and their metadata.
     */
    public array $realms;

    /**
     * @var Links top-level document link to follow for a selected realm ID.
     */
    #[SerializedName('_links')]
    public Links $links;

    public function __construct(
        Links $links,
        array $realms
    ) {
        $this->links = $links;
        $this->realms = $realms;
    }
}
