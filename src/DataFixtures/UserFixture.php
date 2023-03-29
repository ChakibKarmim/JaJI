<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Career;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $career = $manager->getRepository(Career::class)->findall();
        $user = new User();
        $user->setFirstname('Léon');
        $user->setLastname('Blume');
        $user->setPassword('987987');
        $user->setRoles(['ROLE_FORMER']);
        $user->setEmail('lblume@hackathon.fr');
        $user->setCareer($career[0]);
        
        $manager->persist($user);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CareerFixture::class
        ];
    }
}