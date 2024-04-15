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

    /**
     * @param ServiceEntityRepository $entityManager
     */
    public function __construct(GuideRepository $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Guide $key
     * @return Guide
     */
    public function translate(Guide $key): Guide
    {
        $this->translateData($key[self::FIELD_DATA]);
        return $key;
    }

    private function translateData(array $data)
    {
        foreach ($data[self::FIELD_STEPS] as $val) {

        }
    }
}