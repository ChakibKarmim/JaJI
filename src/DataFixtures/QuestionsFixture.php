<?php

namespace App\DataFixtures;

use App\Entity\Questions;
use App\Entity\Quizz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Ramsey\Uuid\Uuid;

class QuestionsFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $quizz = $manager->getRepository(Quizz::class)->findall();
        for($j = 0;$j<=17;$j++){
            $question = new Questions();
            $question->setTitle('Q1');
            $question->setQuizzId($quizz[$j]);
            $question->setQuestion('Quel langage informatique est orienté objet?');
            $question->setHasMultipleChoices(true);
            $question->setChoices(["html","php","javascript","CSS"]);
            $question->setAnswers(["php","javascript"]);
            $manager->persist($question);

            $question = new Questions();
            $question->setTitle('Q2');
            $question->setQuizzId($quizz[$j]);
            $question->setQuestion('Si 1 = 4, 2 = 8 et 3 = 16 a quoi est égale 4?');
            $question->setHasMultipleChoices(false);
            $question->setChoices([1, 4, 32, 64]);
            $question->setAnswers([1]);
            $manager->persist($question);

            $question = new Questions();
            $question->setTitle('Q3');
            $question->setQuizzId($quizz[$j]);
            $question->setQuestion('Quelle viande est considérée comme de la volaille');
            $question->setHasMultipleChoices(true);
            $question->setChoices(["Boeuf","Lapin","Poulet","Porc"]);
            $question->setAnswers(["Lapin","Poulet"]);
            $manager->persist($question);

            $question = new Questions();
            $question->setTitle('Q4');
            $question->setQuizzId($quizz[$j]);
            $question->setQuestion("Quelle est la capitale de l'australie?");
            $question->setHasMultipleChoices(false);
            $question->setChoices(["Canberra","Sydney","Melbourne","Ballarat"]);
            $question->setAnswers(["Canberra"]);
            $manager->persist($question);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            QuizzFixture::class
        ];
    }
}