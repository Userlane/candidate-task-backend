<?php

namespace App\Service;

use App\Entity\Guide;

/**
 * base translation service
 */
interface TranslationService
{
    public function translateKey($sourceLocale, $targetLocale, $key): ?string;
    public function translate(Guide $guide): Guide;
}