<?php

namespace App\Service;

use App\Entity\Guide;

/**
 * base translation service
 */
interface TranslationService
{
    public function translate($sourceLocale, $targetLocale, $key): ?string;
}