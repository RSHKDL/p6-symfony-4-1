<?php

namespace App\Form;

use App\EventSubscriber\UpdateTrickSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

final class UpdateTrickType extends AbstractType
{

    /**
     * @var UpdateTrickSubscriber
     */
    private $updateTrickSubscriber;

    /**
     * UpdateTrickType constructor.
     * @param UpdateTrickSubscriber $updateTrickSubscriber
     */
    public function __construct(UpdateTrickSubscriber $updateTrickSubscriber)
    {
        $this->updateTrickSubscriber = $updateTrickSubscriber;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('imageFeatured')
            ->add('imageFeatured', ImageType::class, [
                'required' => false
            ])
            ->addEventSubscriber($this->updateTrickSubscriber);
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return CreateTrickType::class;
    }
}
