<?php

declare(strict_types=1);

namespace Joeymckenzie\Bubblehearth;

final readonly class OAuthEndpoints
{
    /**
     * Authorize endpoint for global regionalities.
     */
    public const GLOBAL_AUTHORIZE_ENDPOINT = 'https://oauth.battle.net/authorize';

    /**
     * Token endpoint for global regionalities.
     */
    public const GLOBAL_TOKEN_ENDPOINT = 'https://oauth.battle.net/token';

    /**
     * Authorize endpoint for the China regionality.
     */
    public const CN_AUTHORIZE_ENDPOINT = 'https://oauth.battlenet.com.cn/authorize';

    /**
     * Authorize endpoint for China regionality.
     */
    public const CN_TOKEN_ENDPOINT = 'https://oauth.battlenet.com.cn/token';
}
