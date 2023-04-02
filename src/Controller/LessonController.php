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

    #[Route('/lesson/{id}', name: 'app_lesson_show', methods: ['GET'])]
    public function show(Lesson $lesson,LessonRepository $lessonRepository): Response
    {   
        $current_chapter =$lesson->getChapterId()->getId();
        $number_of_lessons_in_current_chapter = $lessonRepository->getLessonsNumberInChapiter($current_chapter);
        $next_lesson = $lessonRepository->getNextPrevLesson($current_chapter,$lesson->getLessonOrder()+1);
        $prev_lesson = $lessonRepository->getNextPrevLesson($current_chapter,$lesson->getLessonOrder()-1);

        $data = [
            'id' => $lesson->getId(),
            'title' => $lesson->getTitle(),
            'Intro' => $lesson->getIntro(),
            'Order' =>  $lesson->getLessonOrder(),
            'duration' => $lesson->getDuration(),
            'content' => $lesson->getContent(),
            'video_url' => $lesson->getVideoUrl(),
            'next' => $next_lesson,
            'prev' => $prev_lesson,
        ];

        return $this->json($lesson);
    }


}
