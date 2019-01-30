<?php

namespace App\Domain\DataFixtures;

use App\Domain\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');

        for ($i = 0; $i < 20; $i++) {
            $comment = new Comment();
            $comment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
            $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
            $comment->setContent($faker->realText(140));
            $comment->setCreatedAt($faker->dateTimeBetween('-1 months', 'now'));
            $manager->persist($comment);
        }
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            TrickFixtures::class,
            UserFixtures::class
        ];
    }
}
