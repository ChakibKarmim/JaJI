<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Repository\CareerRepository;
use App\Repository\FormationsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class FormationController extends AbstractController
{
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
