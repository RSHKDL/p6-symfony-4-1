<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORY_REFERENCE = 'category';

    /**
     * @param ObjectManager $manager
     */
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
            $category = new Category($name);
            $manager->persist($category);
        }

        $manager->flush();
        $this->addReference(self::CATEGORY_REFERENCE, $category);
    }
}
