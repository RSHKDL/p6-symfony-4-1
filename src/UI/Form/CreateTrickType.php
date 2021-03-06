<?php

namespace App\UI\Form;

use App\Domain\DTO\TrickDTO;
use App\Domain\Entity\Category;
use App\Domain\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class CreateTrickType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'help' => 'The name will generate the url of the trick'
            ])
            ->add('description', TextareaType::class)
            ->add('categories', EntityType::class, [
                'class'         => Category::class,
                'choice_label'  => 'name',
                'query_builder' => function(CategoryRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                },
                'multiple'      => true,
                'help'          => 'Choose between 1 and 3 categories'
            ])
            ->add('imageFeatured', ImageType::class, [
                'required'  => true,
                'label'     => 'Add a featured image'
            ])
            ->add('images', CollectionType::class, [
                'entry_type'    => ImageType::class,
                'prototype'		=> true,
                'allow_add'		=> true,
                'allow_delete'	=> true,
                'by_reference' 	=> false,
                'required'		=> false,
                'label'         => false
            ])
            ->add('videos', CollectionType::class, [
                'entry_type'    => VideoType::class,
                'prototype'		=> true,
                'allow_add'		=> true,
                'allow_delete'	=> true,
                'delete_empty'  => true,
                'by_reference' 	=> false,
                'required'		=> false,
                'label'         => false
            ]);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrickDTO::class,
            'validation_groups' => ['trickCreateDTO', 'trickDTO'],
            'empty_data' => function (FormInterface $form) {
                return new TrickDTO(
                    $form->get('name')->getData(),
                    $form->get('description')->getData(),
                    $form->get('imageFeatured')->getData(),
                    $form->get('images')->getData(),
                    $form->get('videos')->getData(),
                    $form->get('categories')->getData()
                );
            }
        ]);
    }
}
