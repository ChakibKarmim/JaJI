<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Career;
use App\Entity\Formations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
        $formation->setDuration(10800000);
        $formation->setDifficulty('easy');
        $formation->setNbLessons(2);
        $formation->setCareer($career[0]);
        $formation->setCareer($user[0]);

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