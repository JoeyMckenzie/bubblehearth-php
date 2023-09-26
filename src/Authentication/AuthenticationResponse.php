<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Authentication;

/**
 * An authentication response model containing the access token and expiration.
 */
final readonly class AuthenticationResponse
{
    /**
     * @param  string  $accessToken represents the access token used to authenticate against Blizzard APIs.
     * @param  string  $tokenType OAuth-based token type, usually a bearer.
     * @param  int  $expiresIn number of seconds until the token expires, usually defaulting to 1 day.
     * @param  string  $sub subscriber of the authentication request, defaults to the client ID of the request.
     * @param  string|null  $scope optional scope associated to the token, mainly used for user profile data.
     */
    public function __construct(
        public string $accessToken,
        public string $tokenType,
        public int $expiresIn,
        public string $sub,
        public ?string $scope
    ) {
    }
}
