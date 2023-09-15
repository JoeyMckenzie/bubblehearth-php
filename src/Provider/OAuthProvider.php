<?php

declare(strict_types=1);

namespace Joeymckenzie\Bubblehearth\Provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;

/**
 * An OAuth provider for connecting to the Blizzard Battle.net authentication APIs.
 */
final readonly class OAuthProvider
{
    /**
     * @param  string  $clientId client ID provided by Blizzard.
     * @param  string  $clientSecret client secret provided by Blizzard.
     * @param  string|null  $redirectUri optional redirect URI, matching what is registered in the Blizzard developer portal.
     * @param  string|null  $authorizeUrl optional authorize endpoint for challenging authentication requests.
     * @param  string|null  $tokenUrl optional token endpoint for request access tokens.
     * @param  string|null  $resourceOwnerUrl optional resource owner details for requesting user info.
     */
    public function __construct(
        protected string $clientId,
        protected string $clientSecret,
        protected ?string $redirectUri = null,
        protected ?string $authorizeUrl = null,
        protected ?string $tokenUrl = null,
        protected ?string $resourceOwnerUrl = null,
    ) {
    }

    public function getClient(): void
    {
        $provider = new GenericProvider([
            'clientId' => 'XXXXXX',    // The client ID assigned to you by the provider
            'clientSecret' => 'XXXXXX',    // The client password assigned to you by the provider
            'redirectUri' => 'https://my.example.com/your-redirect-url/',
            'urlAuthorize' => 'https://service.example.com/authorize',
            'urlAccessToken' => 'https://service.example.com/token',
            'urlResourceOwnerDetails' => 'https://service.example.com/resource',
        ]);

        // If we don't have an authorization code then get one
        if (! isset($_GET['code'])) {
            // Fetch the authorization URL from the provider; this returns the
            // urlAuthorize option and generates and applies any necessary parameters
            // (e.g. state).
            $authorizationUrl = $provider->getAuthorizationUrl();

            // Get the state generated for you and store it to the session.
            $_SESSION['oauth2state'] = $provider->getState();

            // Optional, only required when PKCE is enabled.
            // Get the PKCE code generated for you and store it to the session.
            $_SESSION['oauth2pkceCode'] = $provider->getPkceCode();

            // Redirect the user to the authorization URL.
            header('Location: '.$authorizationUrl);
            exit;

            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || empty($_SESSION['oauth2state']) || $_GET['state'] !== $_SESSION['oauth2state']) {
            if (isset($_SESSION['oauth2state'])) {
                unset($_SESSION['oauth2state']);
            }

            exit('Invalid state');
        } else {
            try {
                // Optional, only required when PKCE is enabled.
                // Restore the PKCE code stored in the session.
                $provider->setPkceCode($_SESSION['oauth2pkceCode']);

                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code'],
                ]);

                // We have an access token, which we may use in authenticated
                // requests against the service provider's API.
                echo 'Access Token: '.$accessToken->getToken().'<br>';
                echo 'Refresh Token: '.$accessToken->getRefreshToken().'<br>';
                echo 'Expired in: '.$accessToken->getExpires().'<br>';
                echo 'Already expired? '.($accessToken->hasExpired() ? 'expired' : 'not expired').'<br>';

                // Using the access token, we may look up details about the
                // resource owner.
                /** @var AccessToken $accessToken */
                $resourceOwner = $provider->getResourceOwner($accessToken);

                var_export($resourceOwner->toArray());

                // The provider provides a way to get an authenticated API request for
                // the service, using the access token; it returns an object conforming
                // to Psr\Http\Message\RequestInterface.
                $request = $provider->getAuthenticatedRequest(
                    'GET',
                    'https://service.example.com/resource',
                    $accessToken
                );
            } catch (IdentityProviderException $e) {
                // Failed to get the access token or user details.
                exit($e->getMessage());
            }
        }
    }
}
