<?php

namespace App\Form\Type;

use App\Entity\Cliente;
use App\Entity\Direccion;
use App\Entity\Estado;
use App\Entity\Pedido;
use App\Entity\Restaurante;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class"=> Pedido::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('total', NumberType::class)
            ->add('fechaEntrega', DateTimeType::class,[
                'widget'=>'single_text',
                'format' => 'dd-MM-yyyy HH:mm',
                'html5' => false
                //Le decimo que le vamos a pasa el Time en formato string
            ])
            ->add('cliente', EntityType::class,[
                'class'=> Cliente::class
            ])
            ->add('estado', EntityType::class,[
                'class'=> Estado::class
            ])
            ->add('restaurante', EntityType::class,[
                'class'=> Restaurante::class
            ])
            ->add('direccion', EntityType::class,[
                'class'=> Direccion::class
            ]);
    }
}