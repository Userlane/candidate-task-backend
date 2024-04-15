<?php

namespace App\Controller;

use App\Entity\Guide;
use App\Service\TranslationService;
use App\Service\TranslationService\ExternalTranslationService;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1', name: 'api_v1_')]
class TranslationController extends AbstractController
{
    private TranslationService  $translationService;

    /**
     * @param TranslationService $translationService
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    #[Route('/auto-translate/{original_language}/{language}/{data}', name: 'translation_index', methods:['get'] )]
    public function index(ManagerRegistry $doctrine, string $original_language, string $language, string $data): JsonResponse
    {
        $guide = new Guide();
        $guide->setOriginalLanguage($original_language);
        $guide->setLanguage($language);

        $this->translationService->translate($guide);
        $entity = $doctrine->getRepository(Guide::class)->find();

//        if (!$entity) {
//            return $this->json('No guide found for id ' . $id, 404);
//        }

        $data =  [
            'id' => $entity->getId(),
            'original_language' => $entity->getName(),
            'description' => $entity->getDescription(),
        ];

        return $this->json($data);
    }
}
