<?php

namespace Joeymckenzie\Bubblehearth\Exceptions;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

/**
 * An exception occurring during any request to retrieve an access token.
 */
final class AccessTokenRequestFailed extends Exception
{
    public function __construct(GuzzleException $guzzleException)
    {
        parent::__construct("An error occurred while attempting to request an access token: $guzzleException");
    }
}
