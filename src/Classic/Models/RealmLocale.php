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
     * @var string represents United States English locale.
     */
    #[SerializedName('zh_CN')]
    public string $chineseCN;

    /**
     * @var string represents Great Britain English locale.
     */
    #[SerializedName('zh_TW')]
    public string $chineseTW;

    /**
     * @var string represents Mexican Spanish locale.
     */
    #[SerializedName('ko_KR')]
    public string $korean;

    /**
     * @var string represents Spain-based Spanish locale.
     */
    #[SerializedName('ru_RU')]
    public string $russian;

    /**
     * @var string represents Portuguese locale.
     */
    #[SerializedName('it_IT')]
    public string $italian;

    /**
     * @var string represents German locale.
     */
    #[SerializedName('fr_FR')]
    public string $french;

    /**
     * @var string represents French locale.
     */
    #[SerializedName('de_DE')]
    public string $german;

    /**
     * @var string represents Italian locale.
     */
    #[SerializedName('pt_BR')]
    public string $portuguese;

    /**
     * @var string represents Russian locale.
     */
    #[SerializedName('es_ES')]
    public string $spanishES;

    /**
     * @var string represents Korean locale.
     */
    #[SerializedName('es_MX')]
    public string $spanishMX;

    /**
     * @var string represents Traditional Chinese locale.
     */
    #[SerializedName('en_GB')]
    public string $englishGB;

    /**
     * @var string represents Simplified Chinese locale.
     */
    #[SerializedName('en_US')]
    public string $englishUS;

    public function __construct(
        string $englishUS,
        string $englishGB,
        string $spanishMX,
        string $spanishES,
        string $portuguese,
        string $german,
        string $french,
        string $italian,
        string $russian,
        string $korean,
        string $chineseTW,
        string $chineseCN,
    ) {
        $this->englishUS = $englishUS;
        $this->englishGB = $englishGB;
        $this->spanishMX = $spanishMX;
        $this->spanishES = $spanishES;
        $this->portuguese = $portuguese;
        $this->german = $german;
        $this->french = $french;
        $this->italian = $italian;
        $this->russian = $russian;
        $this->korean = $korean;
        $this->chineseTW = $chineseTW;
        $this->chineseCN = $chineseCN;
    }
}
