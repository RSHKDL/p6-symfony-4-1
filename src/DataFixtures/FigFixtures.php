<?php

namespace App\DataFixtures;


use App\Entity\Figure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class FigFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');

        for ($i = 0; $i < 15; $i++) {
            $figure = new Figure();
            $figure->setName($faker->words(2, true));
            $figure->setDescription($faker->text(140));
            $figure->setSlug($faker->slug(3, true));
            $manager->persist($figure);
        }

        $manager->flush();

    }
}