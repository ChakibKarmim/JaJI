<?php

namespace App\DataFixtures;

use App\Entity\Chapters;
use App\Entity\Formations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Ramsey\Uuid\Uuid;

class ChaptersFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {   
        $formations = $manager->getRepository(Formations::class)->findall();

        for($i = 0;$i<=5;$i++){
            $chapters = new Chapters();
            $chapters->setTitle('chapitre '.$i+1);
            $chapters->setFormationId($formations[0]);
            $chapters->setChapterOrder($i+1);
            $manager->persist($chapters);
        }

        for($i = 0;$i<=5;$i++){
            $chapters = new Chapters();
            $chapters->setTitle('chapitre '.$i+1);
            $chapters->setFormationId($formations[1]);
            $chapters->setChapterOrder($i+1);
            $manager->persist($chapters);
        }

        for($i = 0;$i<=5;$i++){
            $chapters = new Chapters();
            $chapters->setTitle('chapitre '.$i+1);
            $chapters->setFormationId($formations[2]);
            $chapters->setChapterOrder($i+1);
            $manager->persist($chapters);
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            FormationsFixture::class
        ];
    }
}