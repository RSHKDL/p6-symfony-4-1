<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Figure;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'help' => 'The name will generate the url of the trick'
            ))
            ->add('description')
            ->add('categories', EntityType::class, array(
                'class'         => Category::class,
                'choice_label'  => 'name',
                'query_builder' => function(CategoryRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                },
                'multiple'      => true,
                'help'          => 'Choose between 1 and 3 categories'
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
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
