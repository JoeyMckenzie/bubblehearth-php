<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Authentication;

/**
 * An authentication response model containing the access token and expiration.
 */
final readonly class AuthenticationResponse
{
    public function __construct(
        public string $accessToken,
        public string $tokenType,
        public int $expiresIn,
        public string $sub,
        public ?string $scope
    ) {
    }
}
