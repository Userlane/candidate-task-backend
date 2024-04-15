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

    #[Route('/auto-translate/{id}', name: 'translation_index', methods:['get'] )]
    public function index(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entity = $doctrine->getRepository(Guide::class)->find($id);

        if (!$entity) {
            return $this->json('No guide found for id ' . $id, 404);
        }

        $data =  [
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'description' => $entity->getDescription(),
        ];

        return $this->json($data);
    }
}
