<?php

namespace App\Controller\Api;

use App\Repository\ProvinciasRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProvinciasController extends AbstractApiController
{
    private $repPro;
    private $em;

    public function __construct(
        EntityManagerInterface $em,

        ProvinciasRepository $repPro
    ){
        $this->em =$em;
        $this->repPro = $repPro;

    }

    /**
     * @Rest\Get (path="/provincias")
     *@Rest\View (serializerGroups={"provincias"}, serializerEnableMaxDepthChecks= true)
     */

    public function getProvincias(){
        $provincias = $this->repPro->findAll();
        return $provincias;
    }
}