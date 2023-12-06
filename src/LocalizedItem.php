<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Localities supported by Blizzard's APIs.
 */
final readonly class LocalizedItem
{
    /**
     * @var string represents United States English locale.
     */
    #[SerializedName('en_US')]
    public string $englishUS;

    /**
     * @var string represents Great Britain English locale.
     */
    #[SerializedName('en_GB')]
    public string $englishGB;

    /**
     * @var string represents Mexican Spanish locale.
     */
    #[SerializedName('es_MX')]
    public string $spanishMX;

    /**
     * @var string represents Spain-based Spanish locale.
     */
    #[SerializedName('es_ES')]
    public string $spanishES;

    /**
     * @var string represents Portuguese locale.
     */
    #[SerializedName('pt_BR')]
    public string $portuguese;

    /**
     * @var string represents German locale.
     */
    #[SerializedName('de_DE')]
    public string $german;

    /**
     * @var string represents French locale.
     */
    #[SerializedName('fr_FR')]
    public string $french;

    /**
     * @var string represents Italian locale.
     */
    #[SerializedName('it_IT')]
    public string $italian;

    /**
     * @var string represents Russian locale.
     */
    #[SerializedName('ru_RU')]
    public string $russian;

    /**
     * @var string represents Korean locale.
     */
    #[SerializedName('ko_KR')]
    public string $korean;

    /**
     * @var string represents Traditional Chinese locale.
     */
    #[SerializedName('zh_TW')]
    public string $chineseTW;

    /**
     * @var string represents Simplified Chinese locale.
     */
    #[SerializedName('zh_CN')]
    public string $chineseCN;

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