<?php

namespace App\Tests\Form;

use App\Domain\Entity\User;
use App\UI\Form\UserRegisterType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserRegisterTypeTest extends TypeTestCase
{

    public function testSubmit()
    {
        $form = $this->factory->create(UserRegisterType::class);

        $form->submit([
            'username' => 'john',
            'email' => 'john@doe.com',
            'password' => [
                'first' => 'MyPassword',
                'second' => 'MyPassword'
            ]
        ]);

        static::assertTrue(
            $form->isSubmitted()
        );

        static::assertInstanceOf(
            User::class,
            $form->getData()
        );
    }
}
