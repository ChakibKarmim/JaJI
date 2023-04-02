<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Repository\CareerRepository;
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

        // allow cross origin
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response->setData($formationsData);
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
            'chapters' => $chaptersData,
            'progress' => random_int(0, 100)
        ];

         // allow cross origin
         $response = new JsonResponse();
         $response->headers->set('Access-Control-Allow-Origin', '*');
         return $response->setData($data);

    }

    #[Route('/formations', name: 'app_formation', methods: ['POST'])]
    public function post(FormationsRepository $formationsRepository, Request $request, CareerRepository $caretRepository, UserRepository $userRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $formation = new Formations();
            $formation->setTitle($data['Title']);
            $formation->setDescription($data['Description']);
            $formation->setDifficulty($data['Difficulty']);
            $formation->setCoverUrl($data['Cover_url']);
            $formation->setCareer($caretRepository->findAll()[0]);
            $formation->setAuthorId($userRepository->findAll()[0]);
            $formation->setDuration(2000);
            $formation->setNbLessons(random_int(1,8));

        }
        catch (\Exception $e) {
            return new JsonResponse(['status' => 400, 'message' => $e->getMessage()], 400);
        }

        $formationsRepository->save($formation, true);

        return new JsonResponse(
            [
                'status' => 200,
                'data' => $data
            ], 200
            );
      
    }

    #[Route('/formations/edit/:id', name: 'app_formation', methods: ['PUT'])]
    public function update(Formations $formation, Request $request, FormationRepository $repository)
    {
        
        $data = json_decode($request->getContent(), true);

        try {
           
            if(isset($data['Title']))
            {
                $formation->setTitle($data['Title']);

            }

            if(isset($data['Description']))
            {
                $formation->setDescription($data['Description']);

            }

            if(isset($data['Difficulty']))
            {
                $formation->setDifficulty($data['Difficulty']);

            }

            if(isset($data['Cover_url']))
            {
                $formation->setCoverUrl($data['Cover_url']);

            }
            
        }
        catch (\Exception $e) {
            return new JsonResponse(['status' => 400, 'message' => "Une erreur s'est produite"], 400);
        }

        $repository->save($formation, true);

        return new JsonResponse(
            [
                'status' => 200,
                'data' => $data
            ], 200
            );
    
    }
    
}
