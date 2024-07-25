<?php

namespace App\Form;

use App\Entity\Yard;
use App\Entity\Proposal;
use App\Entity\Urgency;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YardAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city')
            ->add('budget')
            ->add('user')
            ->add('projectDate', null, [
                'widget' => 'single_text'
            ])
            ->add('proposal', EnumType::class, ['class' => Proposal::class])
            ->add('urgency', EnumType::class, ['class' => Urgency::class]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Yard::class,
        ]);
    }
}
