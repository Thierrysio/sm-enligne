<?php

namespace App\Form;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Etrepresent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EtrepresentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datepresence')
            ->add('heuredebut')
            ->add('heurefin')
            ->add('restaurant', EntityType::class, array(
                'class'        => Restaurant::class,
                'choice_label' => 'raisonsociale',
                'multiple' => false  
            ))
            ->add('user', EntityType::class, array(
                'class'        => User::class,
                'choice_label' => 'nom',
                'multiple' => false  
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etrepresent::class,
        ]);
    }
}
