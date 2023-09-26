<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Authentication;

/**
 * An authentication response model containing the access token and expiration.
 */
final readonly class AuthenticationResponse
{
    /**
     * @var string|null optional scope associated to the token, mainly used for user profile data.
     */
    public ?string $scope;

    /**
     * @var string subscriber of the authentication request, defaults to the client ID of the request.
     */
    public string $sub;

    /**
     * @var int number of seconds until the token expires, usually defaulting to 1 day.
     */
    public int $expiresIn;

    /**
     * @var string OAuth-based token type, usually a bearer.
     */
    public string $tokenType;

    /**
     * @var string represents the access token used to authenticate against Blizzard APIs.
     */
    public string $accessToken;

    public function __construct(
        string $accessToken,
        string $tokenType,
        int $expiresIn,
        string $sub,
        ?string $scope
    ) {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->sub = $sub;
        $this->scope = $scope;
    }
}
