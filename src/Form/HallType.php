<?php

namespace App\Form;

use App\Entity\Arrangement;
use App\Entity\Ergonomy;
use App\Entity\Hall;
use App\Entity\Material;
use App\Entity\Software;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HallType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('location')
            ->add('capacity')
            ->add('ergonomy', EntityType::class,[
                'class' => Ergonomy::class,
                'placeholder' => '',
                'multiple'=> true,
            ])
            ->add('material')
            ->add('software')
            ->add('arrangement', EntityType::class,[
                'class' => Arrangement::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hall::class,
        ]);
    }
}
