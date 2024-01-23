<?php

namespace OpenBrewery\OpenBrewery\Breweries;

/**
 * Represents sort order for list search operations.
 */
enum SortOrder: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}