<?php

namespace App\Form;

use App\Entity\Ouvrir;
use App\Entity\Jours;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OuvrirType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heure_debut')
            ->add('heure_fin')
            ->add('ouvert')
            ->add('id_restaurant', EntityType::class, array(
                'class'        => Restaurant::class,
                'choice_label' => 'raisonsociale',
                'multiple' => false  
            ))
            ->add('id_jour', EntityType::class, array(
                'class'        => Jours::class,
                'choice_label' => 'jour',
                'multiple' => false  
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ouvrir::class,
        ]);
    }
}
