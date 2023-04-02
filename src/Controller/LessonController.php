<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\ChaptersRepository;
use App\Repository\FormationsRepository;
use App\Repository\LessonRepository;
use App\Repository\QuizzRepository;
use Doctrine\ORM\NonUniqueResultException;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('api/')]
class LessonController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('lesson/{id}', name: 'app_lesson_show', methods: ['GET'])]
    public function show(Lesson $lesson,
                         LessonRepository $lessonRepository,
                         ChaptersRepository $chaptersRepository,
                         FormationsRepository $formationsRepository,
                         QuizzRepository $quizzRepository
    ): Response
    {
        $current_chapter = $lesson->getChapterId();
        $current_chapter_id = $current_chapter->getId();
        $chapter_obj = $chaptersRepository->findOneBy(['id'=>$current_chapter_id]);
        $current_formation_id = $current_chapter->getFormationId()->getId();
        $chapter_info = $chaptersRepository->getLightInfo($current_chapter_id);
        $formation_info = $formationsRepository->getLightInfo($current_formation_id);
        $next_lesson = $lessonRepository->getNextPrevLesson($current_chapter_id,$lesson->getLessonOrder()+1);
        $next_type = 'lesson';
        $prev_lesson = $lessonRepository->getNextPrevLesson($current_chapter_id,$lesson->getLessonOrder()-1);
        $prev_type = 'lesson';


        if($chapter_obj->getChapterOrder() != 1)
        {
            $prev_chapter = $chaptersRepository->findOneBy(['formation_id'=>$current_formation_id,'chapter_order' => $chapter_obj->getChapterOrder() - 1 ]);
            $prev_quizz = $quizzRepository->findOneByChapter(["chaptre_id"=>$prev_chapter->getId()]);
        }
        else
        {
            $prev_quizz = null;
        }


        $next_quizz = $quizzRepository->findOneByChapter(["chaptre_id"=>$current_chapter_id]);


        if($next_lesson == null )
        {
            $next_lesson = $next_quizz;
            $next_type = 'quizz';
        }


        if($prev_lesson == null && $chapter_obj->getChapterOrder() != 1 )
        {
            $prev_lesson = $prev_quizz;
            $prev_type = 'quizz';
        }
        else if ($prev_lesson == null && $chapter_obj->getChapterOrder() == 1)
        {
            $prev_lesson = "This is the first lesson of the first chapter";
            $prev_type = 'null';
        }

         $data = [
            'current'=>
                [   'id' => $lesson->getId(),
                    'title' => $lesson->getTitle(),
                    'intro' => $lesson->getIntro(),
                    'order' =>  $lesson->getLessonOrder(),
                    'duration' => $lesson->getDuration(),
                    'content' => $lesson->getContent(),
                    'video_url' => $lesson->getVideoUrl(),
                    'type' => 'lesson',
                ],
            'next' =>
                [
                    'content'=>$next_lesson,
                    'type' => $next_type
                ],
            'prev' =>
                [
                    'content'=>$prev_lesson,
                    'type' => $prev_type
                ],
            'chapter' => $chapter_info,
            'formation' => $formation_info,
        ];
        dd($data);
        return $this->json($data);
    }


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
