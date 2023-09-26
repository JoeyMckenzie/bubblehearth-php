<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Models;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Localities supported by Blizzard's APIs.
 */
final readonly class RealmLocale
{
    /**
     * @param  string  $englishUS represents United States English locale.
     * @param  string  $englishGB represents Great Britain English locale.
     * @param  string  $spanishMX represents Mexican Spanish locale.
     * @param  string  $spanishES represents Spain-based Spanish locale.
     * @param  string  $portuguese represents Portuguese locale.
     * @param  string  $german represents German locale.
     * @param  string  $french represents French locale.
     * @param  string  $italian represents Italian locale.
     * @param  string  $russian represents Russian locale.
     * @param  string  $korean represents Korean locale.
     * @param  string  $chineseTW represents Traditional Chinese locale.
     * @param  string  $chineseCN represents Simplified Chinese locale.
     */
    public function __construct(
        #[SerializedName('en_US')]
        public string $englishUS,
        #[SerializedName('en_GB')]
        public string $englishGB,
        #[SerializedName('es_MX')]
        public string $spanishMX,
        #[SerializedName('es_ES')]
        public string $spanishES,
        #[SerializedName('pt_BR')]
        public string $portuguese,
        #[SerializedName('de_DE')]
        public string $german,
        #[SerializedName('fr_FR')]
        public string $french,
        #[SerializedName('it_IT')]
        public string $italian,
        #[SerializedName('ru_RU')]
        public string $russian,
        #[SerializedName('ko_KR')]
        public string $korean,
        #[SerializedName('zh_TW')]
        public string $chineseTW,
        #[SerializedName('zh_CN')]
        public string $chineseCN,
    ) {
    }
}
