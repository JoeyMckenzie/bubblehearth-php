<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Models;

use Bubblehearth\Bubblehearth\Classic\Realms\RealmSearchResultItem;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

/**
 * A generic search result item containing both key and the relevant search data.
 *
 * @template T search result data type.
 */
#[DiscriminatorMap(typeProperty: 'type', mapping: [
    'realms' => RealmSearchResultItem::class,
])]
abstract class GenericSearchResultItem
{
    /**
     * @var DocumentKey search item document key, URL.
     */
    public DocumentKey $key;

    /**
     * @var mixed in theory, this would be our generic type if we controlled the response type.
     */
    public mixed $data;
}
