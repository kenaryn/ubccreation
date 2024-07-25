<?php

namespace App\Form;

use App\Entity\Yard;
use App\Entity\Urgency;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city')
            ->add('budget')
            ->add('date', null, [
                'widget' => 'single_text'
            ])
            ->add('urgency', EnumType::class, ['class' => Urgency::class]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Yard::class,
        ]);
    }
}
