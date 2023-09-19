<?php

declare(strict_types=1);

namespace Joeymckenzie\Bubblehearth;

/**
 * Represents regions associated to their corresponding API gateways.
 */
enum AccountRegion implements AuthorizableEndpoint
{
    /**
     * Represents the China region and China API gateway.
     */
    case CN;
    /**
     * Represents the United States region and Global API gateway.
     */
    case US;
    /**
     * Represents the European Union region and Global API gateway.
     */
    case EU;
    /**
     * Represents the Korean region and Global API gateway.
     */
    case KR;
    /**
     * Represents the Taiwan States region and Global API gateway.
     */
    case TW;

    /**
     * Retrieves the token endpoint mapping based on the target region.
     *
     * @return string mapped token endpoint.
     */
    public function getTokenEndpoint(): string
    {
        return match ($this) {
            self::CN => OAuthEndpoints::CN_TOKEN_ENDPOINT,
            default => OAuthEndpoints::GLOBAL_TOKEN_ENDPOINT
        };
    }
}
