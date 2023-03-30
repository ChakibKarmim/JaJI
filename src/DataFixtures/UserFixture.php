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
        $user->setFirstname('Laila');
        $user->setLastname('Charaoui');
        $user->setPassword('987987');
        $user->setRoles(['ROLE_FORMER']);
        $user->setEmail('lcharaoui@hackathon.fr');
        $user->setCareer($career[4]);
        $manager->persist($user);

        $user = new User();
        $user->setFirstname('Robin');
        $user->setLastname('Sobasto');
        $user->setPassword('987987');
        $user->setRoles(['ROLE_FORMER']);
        $user->setEmail('rsobasto@hackathon.fr');
        $user->setCareer($career[5]);
        $manager->persist($user);

        $user = new User();
        $user->setFirstname('Théo');
        $user->setLastname('Lugat');
        $user->setPassword('987987');
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('tlugat@hackathon.fr');
        $user->setCareer($career[1]);
        $manager->persist($user);

        $user = new User();
        $user->setFirstname('Chakib');
        $user->setLastname('Karmim');
        $user->setPassword('987987');
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('ckarmim@hackathon.fr');
        $user->setCareer($career[2]);
        $manager->persist($user);

        $user = new User();
        $user->setFirstname('Elyas');
        $user->setLastname('Chaimi');
        $user->setPassword('987987');
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('echaimi@hackathon.fr');
        $user->setCareer($career[3]);
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