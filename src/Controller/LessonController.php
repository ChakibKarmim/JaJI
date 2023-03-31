<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonType;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lesson')]
class LessonController extends AbstractController
{
    #[Route('/{id}', name: 'app_lesson_show', methods: ['GET'])]
    public function show(Lesson $lesson,LessonRepository $lessonRepository): Response
    {

        $current_chapter = $lessonRepository->getChapterOfLesson($lesson->getId());
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
