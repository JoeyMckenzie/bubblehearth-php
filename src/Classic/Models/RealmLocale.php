<?php

namespace Bubblehearth\Bubblehearth\Classic\Models;

use Symfony\Component\Serializer\Annotation\SerializedName;

final readonly class RealmLocale
{
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
