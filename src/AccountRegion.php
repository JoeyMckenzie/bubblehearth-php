<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

use Bubblehearth\Bubblehearth\Authentication\AuthorizableEndpoint;
use Bubblehearth\Bubblehearth\Authentication\OAuthEndpoints;

/**
 * Represents regions associated to their corresponding API gateways.
 */
enum AccountRegion: string implements AuthorizableEndpoint
{
    /**
     * Represents the China region and China API gateway.
     */
    case CN = 'cn';
    /**
     * Represents the United States region and Global API gateway.
     */
    case US = 'us';
    /**
     * Represents the European Union region and Global API gateway.
     */
    case EU = 'eu';
    /**
     * Represents the Korean region and Global API gateway.
     */
    case KR = 'kr';
    /**
     * Represents the Taiwan States region and Global API gateway.
     */
    case TW = 'tw';

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
