<?php

namespace App\Controller;

use App\Entity\UserQuizz;
use App\Repository\QuizzRepository;
use App\Repository\UserQuizzRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('api/')]

class QuizzController extends AbstractController
{
   
    #[Route('quizz', name: 'quizz', methods: ['POST'])]
    public function index(Request $request, QuizzRepository $quizzRepository, SerializerInterface $serializer, UserQuizzRepository $userQuizzRepository): Response
    {

        $data = json_decode($request->getContent(), true);

        $quizz = $quizzRepository->find($data['quizzId']);
        $answers = $data['answers'];
        if(isset($data['user'])){
            $user = $data['user'];
            $quizz = $userQuizzRepository->findBy(
                [
                    'user_id' => $user,
                    'quizz_id' => $quizz->getId()
                ]
                );
        }
        $response = new JsonResponse();

        if(!$quizz)
        {
            return new JsonResponse(['status' => 400, 'message' => "Quizz is not found"], 400);
        }

        if($quizz instanceof UserQuizz)
        {
            $questions = $quizzRepository->find($quizz->getQuizzId())->getQuestions();
        }
        else
        {
            $questions = $quizz->getQuestions();
        }  

         foreach($questions as $question)
         {

            if(!$answers[$question->getId()])
            {
                return $response->setData(['status' => 400, 'data' => "answers not found"], 400);
            }


            // one Response is not good so quizz is not valid
            if(!in_array($answers[$question->getId()], $question->getAnswers()))
            {
                return $response->setData(['status' => 200, 'isValid' => false], 200);

            }
         }


        return $response->setData(['status' => 200, 'isValid' => true],200);
    }
}
