<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{
    public function testConstructor()
    {
        $category = new Category('fake category');
        static::assertSame('fake category', $category->getName());
    }
}
