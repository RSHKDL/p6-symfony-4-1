<?php

namespace App\Form;

use App\Entity\Figure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('categories', EntityType::class, array(
                'class'        => 'App\Entity\Category',
                'choice_label' => 'name',
                'multiple'     => true
            ))
            ->add('featuredImage', FileType::class, array(
                'label' => 'Add the featured image (jpg, png)',
                'data_class' => null,
                'required' => false
            ))
            ->add('images', CollectionType::class, array(
                'entry_type'    => ImageType::class,
                'prototype'		=> true,
                'allow_add'		=> true,
                'allow_delete'	=> true,
                'by_reference' 	=> false,
                'required'		=> false,
                'label'         => false
            ))
            ->add('videos', CollectionType::class, array(
                'entry_type'    => VideoType::class,
                'prototype'		=> true,
                'allow_add'		=> true,
                'allow_delete'	=> true,
                'by_reference' 	=> false,
                'required'		=> false,
                'label'         => false
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Save the trick'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
