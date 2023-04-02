<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Repository\QuizzRepository;
use App\Repository\QuestionsRepository;
use App\Repository\ChaptersRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/')]
class QuizzController extends AbstractController
{
    #[Route('quizz/{id}', name: 'app_quizz_show', methods: ['GET'])]
    public function show(Quizz $quizz,QuizzRepository $quizzRepository,QuestionsRepository $questionsRepository, ChaptersRepository $chaptersRepository,LessonRepository $lessonRepository): Response
    {

        $question_data = $questionsRepository->findby(array('quizz_id'=>$quizz->getId()),array());
        $questions = [];
        foreach($question_data as $data){
            $question = [
                'title' => $data->getTitle(),
                'question' => $data->getQuestion(),
                'has_multiple_choice' => $data->isHasMultipleChoices(),
                'choices' => $data->getChoices(),
                'answers' => $data->getAnswers(),
            ];
            $questions[] = $question;
        }

        $totalchapter = count($chaptersRepository->findBy(array('formation_id' => $quizz->getChaptreId()->getFormationId()->getId()),array()));
        $numchapter = $quizz->getChaptreId()->getChapterOrder();
        $totallesson = count($lessonRepository->findBy(array('chapter_id' => $quizz->getChaptreId()->getId()),array()));

        if($numchapter == $totalchapter){
            $next_lessons = "Formation_end";
        }else{
            $next_chapter = $chaptersRepository->findOneBy(array('formation_id' => $quizz->getChaptreId()->getFormationId()->getId(),'chapter_order' => $numchapter+1),array());
            $next_lessons = $lessonRepository->findOneBy(array('chapter_id' => $next_chapter->getId(),'lesson_order' => '1'),array());
            $next_lessons = $next_lessons->getId();
        }

        $previous_lessons = $lessonRepository->findOneBy(array('chapter_id' => $quizz->getChaptreId()->getId(),'lesson_order' => $totallesson),array());
        $data = [
            'current' => [
                'id' => $quizz->getId(),
                'title' => $quizz->getTitle(),
                'chapitre_title' => $quizz->getChaptreId()->getTitle(),
                'question' => $questions,
                'type' => 'quizz'
            ],
            'next' => ['content' => $next_lessons,'type' => 'lesson'],
            'prev' => ['content' => $previous_lessons->getId(),'type' => 'lesson'],
            'chapter' =>['id'=>$quizz->getChaptreId()->getId(),'title'=>$quizz->getChaptreId()->getTitle(),'chapter_order'=>$quizz->getChaptreId()->getChapterOrder()],
            'formation' => ['id'=>$quizz->getChaptreId()->getFormationId()->getId(),'title'=>$quizz->getChaptreId()->getFormationId()->getTitle()],
        ];
        dd($data);
        return $this->json($data);
    }

}