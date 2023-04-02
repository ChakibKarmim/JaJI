<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\ChaptersRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api')]
class LessonController extends AbstractController
{
    #[Route('/lesson', name: 'app_lesson_post', methods: ['POST'])]
    public function post(LessonRepository $lessonRepository, Request $request, ChaptersRepository $chaptersRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        

        try {
            $newLesson = new Lesson();
            $newLesson->setTitle($data['Title']);
            $newLesson->setIntro($data['Intro']);
            $newLesson->setChapterId($chaptersRepository->findAll()[0]);
            $newLesson->setLessonOrder(random_int(1,20));
            $newLesson->setDuration($data["Duration"]);
            $newLesson->setContent($data['Content']);

           $lessonRepository->save($newLesson, true);
        }
        catch (\Exception $e) {
            return new JsonResponse(['status' => 400, 'message' => $e->getMessage()], 400);
        }
       

        return new JsonResponse(
            [
                'status' => 200,
                'data' => $data
            ], 200
            );

    }

}
