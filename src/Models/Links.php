<?php

namespace Bubblehearth\Bubblehearth\Models;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Self reference link for retrieving individual realm data. Not particularly useful,
 * one should favor using the individual self ref for each realm instead.
 */
final readonly class Links
{
    public function __construct(
        /**
         * @var DocumentKey document key, URL.
         */
        #[SerializedName('self')]
        public DocumentKey $key
    ) {
    }
}
