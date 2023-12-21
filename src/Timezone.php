<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

/**
 * Timezones for various endpoints, primarily for used for searching.
 */
enum Timezone: string
{
    /**
     * Represents the America/Los_Angeles western timezone.
     */
    case AmericaLosAngeles = 'America/Los_Angeles';

    /**
     * Represents the America/New_York eastern timezone.
     */
    case AmericaNewYork = 'America/New_York';

    /**
     * Represents the Australian timezone.
     */
    case AustraliaMelbourne = 'Australia/Melbourne';

    /**
     * Represents an unknown, detected when the provided timezone is not able to be parsed.
     */
    case Unknown = 'Unknown';
}
