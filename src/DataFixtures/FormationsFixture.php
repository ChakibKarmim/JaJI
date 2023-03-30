<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Career;
use App\Entity\Formations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Ramsey\Uuid\Uuid;


class FormationsFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $career = $manager->getRepository(Career::class)->findall();
        $user = $manager->getRepository(User::class)->findall();

        $formation = new Formations();
        $formation->setTitle('Formation 1');
        $formation->setDescription('lorem ipsum');
        $formation->setDuration(240000000);
        $formation->setDifficulty('easy');
        $formation->setNbLessons(2);
        $formation->setCareer($career[0]);
        $formation->setAuthorId($user[0]);
        $formation->setCoverUrl('img.png');

        $manager->persist($formation);

        $formation = new Formations();
        $formation->setTitle('Formation 2');
        $formation->setDescription('lorem ipsum 1');
        $formation->setDuration(240000000);
        $formation->setDifficulty('hard');
        $formation->setNbLessons(2);
        $formation->setCareer($career[1]);
        $formation->setAuthorId($user[0]);
        $formation->setCoverUrl('img.png');

        $manager->persist($formation);

        $formation = new Formations();
        $formation->setTitle('Formation 3');
        $formation->setDescription('lorem ipsum 2');
        $formation->setDuration(240000000);
        $formation->setDifficulty('easy');
        $formation->setNbLessons(2);
        $formation->setCareer($career[2]);
        $formation->setAuthorId($user[1]);
        $formation->setCoverUrl('img.png');

        $manager->persist($formation);

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            UserFixture::class
        ];
    }
}