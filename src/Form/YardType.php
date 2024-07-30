<?php

namespace App\Form;

use App\Entity\TypeSite;
use App\Entity\Yard;
use App\Entity\Urgency;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'label' => 'city'
            ])
            ->add('typeSite',EntityType::class,[
                'label' => 'typeSite',
                'class' => TypeSite::class
                ])
            ->add('budget', null, [
                'label' => 'budget',
                'attr' => array(
                    'min' => 1
                )
            ])
            ->add('materials', null, [
                'label' => 'materials'
            ])
            ->add('projectDate', null, [
                'label' => 'projectDate',
                'widget' => 'single_text',
                'attr' => array(
                    'min' => (new \DateTimeImmutable('now'))->format('Y-m-d')
                )
            ])
            ->add('urgency', EnumType::class, [
                'label' => 'urgency',
                'class' => Urgency::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Yard::class,
        ]);
    }
}
