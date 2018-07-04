<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Cork',
            'Rodeo',
            'Flip',
            'One Foot',
            'Old School',
            'New School'
        );

        foreach ($names as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        $this->addReference('category', $category);

        $manager->flush();
    }
}
