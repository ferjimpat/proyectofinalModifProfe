<?php

namespace App\Controller\Api;


use App\Repository\MunicipiosRepository;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MunicipiosController extends AbstractApiController
{
    private $repRes;
    private $repMuni;
    private $em;

    public function __construct(
        EntityManagerInterface $em,
        RestauranteRepository $repRes,
        MunicipiosRepository $repMuni
    ){
        $this->em =$em;
        $this->repMuni = $repMuni;
        $this->repRes = $repRes;
    }

    //Metodo para añadir municipio de reparto a un restaurante

    /**
     * @Rest\Post (path="/restaurante/municipio")
     * @Rest\View (serializerGroups={"add_municipio"}, serializerEnableMaxDepthChecks= true)
     *
     */

    public function restauranteAddMunicipio(Request $request){
        $rest = $request->get('restaurante');
        $muni = $request->get('municipio');
        if(!$rest || !$muni){
            return new Response('Bad data',Response::HTTP_BAD_REQUEST);
        }
        $restaurante = $this->repRes->find($rest);
        //Comprobar que existe
        $municipio = $this->repMuni->find($muni);
        $restaurante->addMunicipiosReparto($municipio);
        $this->em->persist($restaurante);
        $this->em->flush();
        return $municipio;
    }
    /**
     * @Rest\Get (path="/municipios/{id}")
     * @Rest\View (serializerGroups={"add_municipio"}, serializerEnableMaxDepthChecks= true)
     */

    public function getMunicipios(Request $request){
        $idProv = $request->get('id');
        $municipios = $this->repMuni->findBy(['idProvincia'=> $idProv]);
        return $municipios;
    }

}