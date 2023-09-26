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
        #[SerializedName('zh_CN')]
        public string $englishUS,
        #[SerializedName('zh_TW')]
        public string $englishGB,
        #[SerializedName('ko_KR')]
        public string $spanishMX,
        #[SerializedName('ru_RU')]
        public string $spanishES,
        #[SerializedName('it_IT')]
        public string $portuguese,
        #[SerializedName('fr_FR')]
        public string $german,
        #[SerializedName('de_DE')]
        public string $french,
        #[SerializedName('pt_BR')]
        public string $italian,
        #[SerializedName('es_ES')]
        public string $russian,
        #[SerializedName('es_MX')]
        public string $korean,
        #[SerializedName('en_GB')]
        public string $chineseTW,
        #[SerializedName('en_US')]
        public string $chineseCN,
    ) {
    }
}
