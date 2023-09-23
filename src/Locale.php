<?php

namespace Bubblehearth\Bubblehearth;

/** Localities and internationalize data used to query Blizzard, currently supporting:
 *
 * English (United States) => en_US
 * English (Great Britain) => en_GB
 * Spanish (Mexico) => es_MX
 * Spanish (Spain) => es_ES
 * Portuguese => pt_BR
 * German => de_DE
 * French => fr_FR
 * Italian => it_IT
 * Russian => ru_RU
 * Korean => ko_KR
 * Chinese (Traditional) => zh_TW
 * Chinese (Simplified) => zh_CN
 */
enum Locale: string
{
    /**
     * Represents United States English locale.
     */
    case EnglishUS = 'en_US';

    /**
     * Represents Great Britain English locale.
     */
    case EnglishGB = 'en_GB';

    /**
     * Represents Mexican Spanish locale.
     */
    case SpanishMX = 'es_MX';

    /**
     * Represents Spain-based Spanish locale.
     */
    case SpanishES = 'es_ES';

    /**
     * Represents Portuguese locale.
     */
    case Portuguese = 'pt_BR';

    /**
     * Represents German locale.
     */
    case German = 'de_DE';

    /**
     * Represents French locale.
     */
    case French = 'fr_FR';

    /**
     * Represents Italian locale.
     */
    case Italian = 'it_IT';

    /**
     * Represents Russian locale.
     */
    case Russian = 'ru_RU';

    /**
     * Represents Korean locale.
     */
    case Korean = 'ko_KR';

    /**
     * Represents Traditional Chinese locale.
     */
    case ChineseTW = 'zh_TW';

    /**
     * Represents Simplified Chinese locale.
     */
    case ChineseCN = 'zh_CN';
}
