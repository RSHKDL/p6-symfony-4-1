<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'label'             => false,
                'data_class'        => null,
                'required'          => false,
                'image_property'    => 'name',
                'help'          => 'Must be a valid jpg or png file (500ko max)',
                'constraints'       => array(
                    new File()
                )
            ))
            /*->add('isFeatured', ChoiceType::class, array(
                'choice_name'   => 'featured',
                'label'         => 'Is featured ?',
                'expanded'      => true,
                'multiple'      => false,
                'required'      => false
            ))*/
            ->add('isFeatured', CheckboxType::class, array(
                'label'         => 'Is featured ?',
                'required'      => false
            ));
            /*->addEventListener(
                FormEvents::POST_SET_DATA,
                array($this, 'onPostSetData')
            )*/
    }

    /*
     * Cause the image Collection to be deleted on update.
     */
    public function onPostSetData(FormEvent $event)
    {
        if ($event->getData() && $event->getData()->getId()) {
            $form = $event->getForm();
            unset($form['file']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
