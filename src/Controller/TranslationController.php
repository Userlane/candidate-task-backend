<?php

namespace App\Controller;

use App\Entity\Data;
use App\Entity\Guide;
use App\Entity\Step;
use App\Service\TranslationService;
use App\Service\TranslationService\ExternalTranslationService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
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
    public function __construct(ExternalTranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    #[Route('/auto-translate/{original_language}/{language}/{data}', name: 'translation_index', methods:['get'] )]
    public function index(/*ManagerRegistry $doctrine, */string $original_language, string $language, string $data, SerializerInterface $serializer): JsonResponse
    {
        $guide = new Guide();
        $guide->setOriginalLanguage($original_language);
        $guide->setLanguage($language);
        $dataJsonDecode = json_decode($data, true);
//        var_dump($dataJsonDecode);
        $stepsDeserialized = $serializer->deserialize(json_encode($dataJsonDecode['steps']), 'App\Entity\Step[]', 'json');
//        var_dump($stepsDeserialized);

        $dataDeserialized = $serializer->deserialize($data, Data::class, 'json');
//        var_dump($dataDeserialized);
        foreach ($stepsDeserialized as $step) {
            $dataDeserialized->addStep($step);
        }
        $guide->addData($dataDeserialized);

//        $entity = $doctrine->getRepository(Guide::class)->find();

        $guideTranslated = $this->translationService->translate($guide);
//        if (!$entity) {
//            return $this->json('No guide found for id ' . $id, 404);
//        }

        $out =  [
//            'id' => $entity->getId(),
            $guideTranslated
        ];

        return $this->json($out);
    }
    #[Route('/test', name: 'test', methods:['get'] )]
    public function test(): JsonResponse
    {
        return $this->json("X");
    }

}
