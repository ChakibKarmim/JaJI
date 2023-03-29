<?php

namespace App\DataFixtures;

use App\Entity\Career;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CareerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $career = new Career();
        $career->setTags(['Company', 'Business Advisors','Customer Relationship','Care Manager']);
        $manager->persist($career);

        $manager->flush();
    }
}