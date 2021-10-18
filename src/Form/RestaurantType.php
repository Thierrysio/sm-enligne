<?php

namespace App\Form;
use App\Entity\Categories;
use App\Entity\Restaurant;
use App\Entity\Description;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raisonsociale')
            ->add('adresse')    
            ->add('ville')
            ->add('longitude')
            ->add('latitude') 
            ->add('infos')
            ->add('avantages')
            ->add('image')
            ->add('categorie', EntityType::class, array(
                'class'        => Categories::class,
                'choice_label' => 'nom',
                'multiple' => true  
            )) 
               
                ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
