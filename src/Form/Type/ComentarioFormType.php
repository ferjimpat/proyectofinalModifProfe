<?php

namespace App\Form\Type;

use App\Entity\Comentario;
use App\Entity\Restaurante;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ComentarioFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> Comentario::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'nombre', TextType::class)
        ->add('comentario', TextType::class, [
            'required'=>false
        ])
            ->add('puntos', NumberType::class)
            ->add('restaurante', EntityType::class,[
                'class'=> Restaurante::class,
                'constraints'=>[
                    new NotNull()
                ]
            ]);
    }
}