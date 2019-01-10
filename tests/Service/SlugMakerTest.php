<?php

namespace App\Tests\Service;

use App\Service\SlugMaker;
use PHPUnit\Framework\TestCase;

class SlugMakerTest extends TestCase
{
    public function testSlugify()
    {
        $slugMaker = new SlugMaker();

        $this->assertSame(
            'medes-lok-nak',
            $slugMaker->slugify('Médês@ Lok$* _nàk', true));

        $this->assertSame(
            'medes_lok_nak',
            $slugMaker->slugify('Médês@ Lok$* _nàk', false));
    }
}
