<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('plainPassword', RepeatedType::class, array(
                'type'              => PasswordType::class,
                'required'          => false,
                'first_options'     => array('label' => 'New password'),
                'second_options'    => array('label' => 'Confirm new password'),
                'invalid_message'   => 'The fields doesn\'t match'
            ))
        ;
    }
}
