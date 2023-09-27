<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Models;

use Bubblehearth\Bubblehearth\Models\DocumentKey;

/**
 * Realm region data, including document links and name.
 */
final readonly class RealmRegion
{
    /**
     * @var int ID of the realm region.
     */
    public int $id;

    /**
     * @var RealmLocale|string name of the realm region.
     */
    public RealmLocale|string $name;

    /**
     * @var DocumentKey key to the realm region, URL.
     */
    public DocumentKey $key;

    public function __construct(
        int $id,
        DocumentKey $key,
        string|RealmLocale $name
    ) {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
    }
}
