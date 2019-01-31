<?php

namespace App\Tests\Entity;

use App\Domain\Entity\Category;
use App\Domain\Entity\Image;
use App\Domain\Entity\Trick;
use App\Domain\Entity\User;
use App\App\Service\SlugMaker;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TrickTest extends TestCase
{
    public function testGetName() {
        $author = new User();
        $category = new Category('Fake category');
        $imageFeatured = new Image('fake image', '/fake/path', 'fake-image');
        $slugMaker = new SlugMaker();
        $trick = new Trick(
            'Fake Trick',
            'Fake description',
            $author,
            $imageFeatured,
            [],
            [],
            new ArrayCollection([$category]),
            $slugMaker
        );

        static::assertSame('Fake Trick', $trick->getName());
    }
}
