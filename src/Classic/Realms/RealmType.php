<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Realms;

class RealmType
{
    /**
     * @param  string  $type  normalized realm type.
     * @param  string  $name  user-friendly name of the realm type.
     */
    public function __construct(public string $type, public string $name)
    {
    }
}
