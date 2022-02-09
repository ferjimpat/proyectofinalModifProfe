<?php

namespace App\Form\Type;

use App\Entity\Categorias;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriaFormType extends AbstractType
{
    // buidForm-> Se encarga de comprobar que este todo ok

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoria', TextType::class);
    }

    // Definir a que objeto hace referencia

    public function  configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> Categorias::class
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