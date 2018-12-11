<?php

namespace App\Form;

use App\DTO\VideoDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'label' => false,
                'help' => 'Must be the raw url of the video (youtube, dailymotion or vimeo)'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VideoDTO::class,
            'validation' => ['TrickDTO'],
            'error_bubbling' => true,
            'empty_data' => function (FormInterface $form) {
                return new VideoDTO(
                    $form->get('url')->getData()
                );
            }
        ]);
    }
}
