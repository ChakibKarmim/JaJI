<?php

namespace App\Controller;

use App\Repository\LessonRepository;
use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('api/')]
class AllController extends AbstractController
{
    #[Route('content/all', name: 'get_lesson_quizz_content', methods: ['GET'])]
    public function show(Request $request,LessonRepository $lessonRepository,QuizzRepository $quizzRepository): Response
    {
        $type = $request->get('type');
        $id = $request->get('id');
        if($type === 'lesson')
        {
            $lesson = $lessonRepository->findOneBy(['id'=>$id]);
            if ($lesson)
            {
                return $this->redirectToRoute('app_lesson_show', ['id' => $id]);
            }
            return $this->json('lesson not found');
        }
        elseif($type === 'quizz')
        {
            $quizz = $quizzRepository->findOneBy(['id'=>$id]);
            if(!$quizz)
            {
                return $this->json('quizz not found');
            }
            return $this->redirectToRoute('app_quizz_show',['id' => $id]);
        }
        return $this->json('wrong route params');
    }

}