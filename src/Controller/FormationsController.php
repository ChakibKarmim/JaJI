<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Repository\FormationsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formations')]
class FormationsController extends AbstractController
{
    #[Route('/all', name: 'app_formations_index', methods: ['GET'])]
    public function index(FormationsRepository $formationsRepository,UserRepository $userRepository): Response
    {
        $formations = $formationsRepository->findAll();
        $info = new JsonResponse();

        foreach ($formations as $formation)
        {
            $user = $userRepository->find($formation->getAuthorId());
            $name = " ".$user->getFirstname()." ".$user->getLastname()." ";
            $info = $this->json([
                'id' => $formation->getId(),
                'title' => $formation->getTitle(),
                'description' => $formation->getDescription(),
                'author' =>  $name,
                'duration' => $formation->getDuration(),
                'nb_lesson' => $formation->getNbLessons(),
            ]);
        }

        return $info;
    }

    #[Route('/{id}', name: 'app_formation_', methods: ['GET'])]
    public function show(Formations $formation,UserRepository $userRepository): Response
    {
        $user = $userRepository->find($formation->getAuthorId());
        $name = " ".$user->getFirstname()." ".$user->getLastname()." ";
        $formation_chapters = $formation->getChaptre();

        return $this->json([
            'id' => $formation->getId(),
            'title' => $formation->getTitle(),
            'description' => $formation->getDescription(),
            'author' =>  $name,
            'duration' => $formation->getDuration(),
            'chapters' => $formation_chapters,
            'formation' => $formation,
        ]);
    }












    #[Route('/new', name: 'app_formations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormationsRepository $formationsRepository): Response
    {
        $formation = new Formations();
        $form = $this->createForm(FormationsType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationsRepository->save($formation, true);

            return $this->redirectToRoute('app_formations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formations/new.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formations $formation, FormationsRepository $formationsRepository): Response
    {
        $form = $this->createForm(FormationsType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationsRepository->save($formation, true);

            return $this->redirectToRoute('app_formations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formations/edit.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formations_delete', methods: ['POST'])]
    public function delete(Request $request, Formations $formation, FormationsRepository $formationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $formationsRepository->remove($formation, true);
        }

        return $this->redirectToRoute('app_formations_index', [], Response::HTTP_SEE_OTHER);
    }
}
