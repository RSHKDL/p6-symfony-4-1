<?php

namespace App\UI\Form;

use App\Domain\DTO\ImageDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ImageType
 * @package App\UI\Form
 */
final class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'help'  => 'Must be a valid jpg or png file (500ko max)',
                'attr'  => [
                    'accept' => '.jpeg, .jpg, .png'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageDTO::class,
            'validation_groups' => ['trickDTO'],
            'error_bubbling' => true,
            'empty_data' => function (FormInterface $form) {
                return new ImageDTO(
                    $form->get('file')->getData()
                );
            }
        ]);
    }
}
