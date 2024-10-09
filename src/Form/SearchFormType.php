<?php

namespace App\Form;

use App\Entity\Hall;
use App\Entity\Material;
use App\Entity\Ergonomy;
use App\Entity\Software;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        
        $builder ->add('Capacity')
            ->add('Material', EntityType::class, [
                'class' => Material::class,
                'multiple'=> true,
            ])
            ->add('Software', EntityType::class, [
                'class' => Software::class,
                'multiple'=> true,
            ])
            ->add('Ergonomy', EntityType::class, [
                'class' => Ergonomy::class,
                'multiple'=> true,
            ])
            
            ->getForm();
    }

    
}
