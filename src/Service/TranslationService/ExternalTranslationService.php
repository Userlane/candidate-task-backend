<?php

namespace App\Service\TranslationService;

use App\Entity\Guide;
use App\Repository\GuideRepository;
use App\Service\TranslationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * class for external translation
 */
class ExternalTranslationService implements TranslationService
{
    const FIELD_DATA = "data";
    const FIELD_STEPS = "steps";
    private ServiceEntityRepository $entityManager;

    private array $dictionary;
    /**
     * @param ServiceEntityRepository $entityManager
     */
    public function __construct(GuideRepository $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->dictionary = [
            'en_US_it_IT'=>[
                "A nice guide" => "Una bella guida",
                "some content"=>"del contenuto",
                "some other content"=>"dell'altro contenuto"
            ],
        ];
    }

    /**
     * @param string $key
     * @return string
     */
    public function translateKey($sourceLocale, $targetLocale, $key): ?string
    {
        $locale = $sourceLocale."_".$targetLocale;
        $dictKey = isset($this->dictionary[$locale]);
        $val = $dictKey && isset($this->dictionary[$locale][$key]) ? $this->dictionary[$locale][$key] : null;
        return $val;
    }
    public function translate(Guide $guide): Guide
    {
        $sourceLocale = $guide->setOriginalLanguage();
        $targetLocale = $guide->getLanguage();
        $guideTranslated = new Guide();
        $guideTranslated->setOriginalLanguage($sourceLocale);
        $guideTranslated->setLanguage($targetLocale);

        $data = $guide->getData();
//        $data->
        return $guideTranslated;
    }
}