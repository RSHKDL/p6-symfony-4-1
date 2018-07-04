<?php

namespace App\DataFixtures;


use App\Entity\Category;
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
        $faker = Faker\Factory::create('en_GB');

        for ($i = 0; $i < 20; $i++) {
            $figure = new Figure();
            $figure->setName($faker->catchPhrase());
            $figure->setDescription($faker->realText(360));
            $figure->addCategory($this->getReference('category'));
            $manager->persist($figure);
        }

        $manager->flush();

    }
}