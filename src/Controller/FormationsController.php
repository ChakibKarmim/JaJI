<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Repository\FormationsRepository;
use App\Repository\LessonRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/')]
class FormationsController extends AbstractController
{
    #[Route('formations/all', name: 'app_formations_index', methods: ['GET'])]
    public function index(FormationsRepository $formationsRepository,UserRepository $userRepository,Request $request): Response
    {
        $formations = $formationsRepository->findAll();
        $formationsData = [];

        foreach ($formations as $formation) {
            $user = $userRepository->find($formation->getAuthorId());
            $name = " ".$user->getFirstname()." ".$user->getLastname()." ";

            $formationData = [
                'id' => $formation->getId(),
                'title' => $formation->getTitle(),
                'description' => $formation->getDescription(),
                'author' =>  $name,
                'duration' => $formation->getDuration(),
                'nb_lesson' => $formation->getNbLessons(),
            ];

            $formationsData[] = $formationData;
        }

        return $this->json($formationsData);
    }

    #[Route('formations/{id}', name: 'app_formation_light', methods: ['GET'])]
    public function getFormationInfo(Formations $formation,UserRepository $userRepository,LessonRepository $lessonRepository): Response
    {
        $user = $userRepository->find($formation->getAuthorId());
        $name = " ".$user->getFirstname()." ".$user->getLastname()." ";
        $formation_chapters = $formation->getChaptre();
        $chaptersData = [];

        foreach ($formation_chapters as $chapter) {
            $chapterData = [
                'id' => $chapter->getId(),
                'title' => $chapter->getTitle(),
                'order' => $chapter->getChapterOrder(),
                'lessons' => $lessonRepository->findLessonsLightByChapter($chapter->getId()),
            ];
            $chaptersData[] = $chapterData;
        }

        $data = [
            'id' => $formation->getId(),
            'title' => $formation->getTitle(),
            'description' => $formation->getDescription(),
            'author' =>  $name,
            'duration' => $formation->getDuration(),
            'chapter' => $chaptersData,
        ];

        return $this->json($data);
    }
}
