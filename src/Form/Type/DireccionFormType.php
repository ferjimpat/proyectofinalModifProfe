<?php
namespace App\Form\Type;


use App\Entity\Cliente;
use App\Entity\Direccion;
use App\Entity\Municipios;
use App\Entity\Provincias;
use App\Entity\Restaurante;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class DireccionFormType extends AbstractType
{
    public function  configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> Direccion::class
        ]);
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('calle', TextType::class)
            ->add('numero',TextType::class, [
                'required'=> false
            ])
            ->add('puertaPisoEscalera', TextType::class, [
                'required'=> false
            ])
            ->add('codPostal', NumberType::class)
            ->add('cliente', EntityType::class,[
                'class'=> Cliente::class,
                'constraints'=>[
                    new NotNull()
                ]
            ])
            ->add('municipio', EntityType::class,[
                'class'=> Municipios::class,
                'constraints'=>[
                    new NotNull()
                ]
            ])
            ->add('provincia', EntityType::class,[
                'class'=> Provincias::class,
                'constraints'=>[
                    new NotNull()
                ]
            ]);
    }




}
