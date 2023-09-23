<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

/**
 * A structure that may contain an authoriablble endpoint mapping, primarily used for tokens and user info.
 */
interface AuthorizableEndpoint
{
    /**
     * Maps an endpoint from the associated client region.
     *
     * @return string token endpoint.
     */
    public function getTokenEndpoint(): string;
}
