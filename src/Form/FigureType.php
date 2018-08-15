<?php

namespace App\Form;

use App\Entity\Figure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
                'label' => 'Add an image (jpg, png)'
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Create trick'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
