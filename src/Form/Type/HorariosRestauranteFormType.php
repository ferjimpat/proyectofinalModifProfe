<?php

namespace App\Form\Type;

use App\Entity\Categorias;
use App\Entity\HorarioRestaurante;
use App\Entity\Restaurante;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class HorariosRestauranteFormType extends AbstractType
{

    // Se establecen los campos (propiedades de la entidad )
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dia', IntegerType::class)
            ->add('apertura',TimeType::class,[
                'widget'=>'single_text' //Le decimo que le vamos a pasa el Time en formato string
            ])
            ->add('cierre', TimeType::class, [
                'widget'=>'single_text'
            ])
            ->add('restaurante', EntityType::class,[
                'class'=> Restaurante::class,
                'constraints'=>[
                    new NotNull()
                ]
            ]);
    }

    // Definir a que objeto hace referencia

    public function  configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> HorarioRestaurante::class
        ]);
    }

}