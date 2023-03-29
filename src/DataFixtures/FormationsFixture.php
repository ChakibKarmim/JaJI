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
        $formation->setDuration(10800000);
        $formation->setDifficulty('easy');
        $formation->setNbLessons(2);
        $formation->setCareer($career[0]);
        $formation->setAuthorId($user[0]);
        $formation->setCoverUrl('img.png');

        $manager->persist($formation);

        $formation = new Formations();
        $formation->setTitle('Formation 2');
        $formation->setDescription('lorem ipsum');
        $formation->setDuration(21600000);
        $formation->setDifficulty('hard');
        $formation->setNbLessons(2);
        $formation->setCareer($career[1]);
        $formation->setAuthorId($user[0]);
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