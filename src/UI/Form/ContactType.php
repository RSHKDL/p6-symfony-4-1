<?php

namespace App\UI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class)
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Bug report'            => 'Bug report',
                    'Improvement request'   => 'Improvement request',
                    'Thanks'                => 'Thanks',
                    'Other'                 => 'Other'
                ]
            ])
            ->add('message', TextareaType::class)
        ;
    }
}
