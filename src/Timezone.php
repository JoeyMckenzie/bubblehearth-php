<?php

namespace Bubblehearth\Bubblehearth;

/**
 * Timezones for various endpoints, primarily for used for searching.
 */
enum Timezone
{
    /**
     * Represents the America/Los_Angeles western timezone.
     */
    case AmericaLosAngeles;

    /**
     * Represents the America/New_York eastern timezone.
     */
    case AmericaNewYork;

    /**
     * Represents an unknown, detected when the provided timezone is not able to be parsed.
     */
    case Unknown;
}
