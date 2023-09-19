<?php

declare(strict_types=1);

namespace Joeymckenzie\Bubblehearth;

use DateTime;

/**
 * Represents the authentication response context.
 */
final readonly class AuthenticationContext
{
    /**
     * @var string access token returned from client credentials authentication.
     */
    public string $accessToken;

    /**
     * @var int expiration in seconds until the token needs to be refreshed.
     */
    public int $expiresIn;

    /**
     * @var DateTime internally tracked expiration date/time of the current access token.
     */
    private DateTime $expiresAt;

    public function __construct(string $accessToken, int $expiresIn)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $currentDateTime = new DateTime();
        $this->expiresAt = $currentDateTime->modify('+'.$expiresIn.' seconds');
    }

    /**
     * Checks the current expiration of the access token to determine if a new one is needed.
     *
     * @return bool true, if the refresh is needed.
     */
    public function refreshRequired(): bool
    {
        return $this->expiresAt < new DateTime();
    }
}
