<?php

namespace App\Tests\Entity;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TrickTest extends TestCase
{
    public function testGetName() {
        $author = new User();
        $imageFeatured = new Image('fake image', '/fake/path', 'fake-image');
        $trick = new Trick(
            'Fake Trick',
            'Fake description',
            $author,
            $imageFeatured,
            [],
            [],
            new ArrayCollection(['Fake category'])
        );
    }

}