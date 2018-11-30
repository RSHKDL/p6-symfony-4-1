<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
            'empty_data' => function(FormInterface $form) {
                return new ContactDTO(
                    $form->get('name')->getData(),
                    $form->get('email')->getData(),
                    $form->get('subject')->getData(),
                    $form->get('message')->getData()
                );
            }
        ]);
    }
}
