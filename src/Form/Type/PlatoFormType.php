<?php

namespace App\Form\Type;

use App\Entity\Plato;
use App\Entity\Restaurante;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlatoFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class)
            ->add('descripcion', TextType::class, ['required'=>false])
            ->add('imagenUrl', TextType::class, ['required'=>false])
            ->add('precio', NumberType::class)
            ->add('restaurante', EntityType::class,[
                'class'=> Restaurante::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class"=> Plato::class
        ]);
    }

}