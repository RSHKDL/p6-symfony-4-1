<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    const TRICK_REFERENCE = 'trick';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        $user = $this->getReference(UserFixtures::USER_REFERENCE);
        $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE);

        for ($i = 0; $i < 20; $i++) {
            $trick = new Trick(
                $faker->catchPhrase(),
                $faker->realText(360),
                null,
                null,
                [],
                [],
                null
            );
            $trick->setAuthor($user);
            $trick->addCategory($category);
            $trick->setCreatedAt($faker->dateTimeBetween('-1 months', 'now'));
            $manager->persist($trick);
            $this->setReference(self::TRICK_REFERENCE, $trick);
        }
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }
}
