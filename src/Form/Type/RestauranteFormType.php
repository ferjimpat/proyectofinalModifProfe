<?php

namespace App\Form\Type;

use App\Entity\Restaurante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestauranteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class)
            ->add('logoUrl', TextType::class)
            ->add('imagenUrl', TextType::class, [
                'required'=> false
            ])
            ->add('descripcion', TextType::class, [
                'required'=>false
            ])
            ->add('valoracionMedia', NumberType::class, [
                'required'=> false

            ])
            ->add('destacado', CheckboxType::class, [
                'required' =>false
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurante::class
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

    public function getName(){
        return '';
    }


}