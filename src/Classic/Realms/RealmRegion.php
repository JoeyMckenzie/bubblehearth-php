<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

use Bubblehearth\Bubblehearth\Models\DocumentKey;

/**
 * Realm region data, including document links and name.
 */
final readonly class RealmRegion
{
    /**
     * @var null|int ID of the realm region.
     */
    public ?int $id;

    /**
     * @var string name of the realm region.
     */
    public string $name;

    /**
     * @var null|DocumentKey key to the realm region, URL.
     */
    public ?DocumentKey $key;

    public function __construct(
        int $id,
        DocumentKey $key,
        string $name
    ) {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
    }
}
