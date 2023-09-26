<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Self reference link for retrieving individual realm data. Not particularly useful,
 * one should favor using the individual self ref for each realm instead.
 */
final readonly class Links
{
    /**
     * @var DocumentKey URL document key.
     */
    #[SerializedName('self')]
    public DocumentKey $key;

    public function __construct(DocumentKey $key)
    {
        $this->key = $key;
    }
}
