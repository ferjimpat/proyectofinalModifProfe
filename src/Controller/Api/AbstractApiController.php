<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;

class AbstractApiController extends AbstractFOSRestController
{

    // Esto hace de intermediario con formularios, para no tener que implementar las
    // dos funciones extras cada vez que creo un formType.
    protected function buildForm(string $type, $data=null, array $options=[]):FormInterface
    {
        $options= array_merge($options,array('csrf_protection'=>false));
        return  $this->container->get('form.factory')->createNamed('', $type, $data, $options);
    }


}