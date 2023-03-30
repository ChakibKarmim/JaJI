<?php

namespace App\DataFixtures;

use App\Entity\Chapters;
use App\Entity\Quizz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Ramsey\Uuid\Uuid;

class QuizzFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $chapters = $manager->getRepository(Chapters::class)->findall();
        $i=1;
        $k=1;
            for($j = 0;$j<=17;$j++){
                $quizz = new Quizz();
                $quizz->setTitle('Quizz formation '.$i.' chapitre '.$k);
                if($k<6){
                    $k++;
                }else{
                    $k=1;
                    $i++;
                }
                $quizz->setChaptreId($chapters[$j]);
                $manager->persist($quizz);
            }
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            ChaptersFixture::class
        ];
    }
}