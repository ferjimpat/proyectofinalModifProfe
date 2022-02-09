<?php

namespace App\Form\Type;

use App\Entity\CantidadPlatosPedido;
use App\Entity\Pedido;
use App\Entity\Plato;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CantidadPlatosPedidoFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class'=> CantidadPlatosPedido::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cantidad', NumberType::class)


            ->add('plato', EntityType::class,[
                'class'=> Plato::class
            ]);
    }

}