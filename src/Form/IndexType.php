<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class IndexType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('cat', EntityType::class, array(
                'class'        => Categories::class,
                'choice_label' => 'nom',
                'label' => false ,
                'multiple' => false  
            ))
                
                ->add('rest', EntityType::class, array(
                'class'        => Restaurant::class,
                 'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('u')
            ->groupBy('u.ville');
    },
                'choice_label' => 'ville',
                    'label' => false ,
                'multiple' => false  
            ));
                
                
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }
}
