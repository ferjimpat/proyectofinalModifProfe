<?php

namespace App\Controller\Api;

use App\Entity\Restaurante;
use App\Form\Type\RestauranteFormType;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/restaurante")
 */
class RestaurantesController extends AbstractFOSRestController
{
    private $restauranteRepository;
    private $em;

    public function  __construct(RestauranteRepository $restauranteRepository, EntityManagerInterface $em){
        $this->em = $em;
        $this->restauranteRepository = $restauranteRepository;
    }

    //Devolver listado de restaurante
    /**
     * @Rest\Get (path="/list")
     * @Rest\View (serializerGroups={"restaurante_list"}, serializerEnableMaxDepthChecks=true)
     */

    public function restauranteList(){
        $restaurantes =$this->restauranteRepository->findAll();
        if(!$restaurantes){
            return new Response('Not found', Response::HTTP_NOT_FOUND);
        }
        return $restaurantes;

    }

    //Devolver un restaurante por Id

    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"restaurante_id"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function getRestaurante(Request $request)
    {
        $id = $request->get('id');
        if(!$id){
            return new Response('Not id send', Response::HTTP_BAD_REQUEST);
        }
        $restaurante = $this->restauranteRepository->find($id);
        if(!$restaurante){
            return new Response('Not found', Response::HTTP_NOT_FOUND);
        }
        return $restaurante;

    }

    /**
     * @Rest\Post (path="")
     * @Rest\View  (serializerGroups={"restaurante"} ,serializerEnableMaxDepthChecks=true)
     *
     */

    public function restauranteCreate(Request $request){
        $restaurante = new Restaurante();
        $restaurante->setValoracionMedia(intval(0));
        //Crearno un form, este recive dos argumentos:
        // El tipo formulario, y el objeto al que va asociado
        $form = $this->createForm(RestauranteFormType::class, $restaurante);
        // Le decimos al formulario que maneje la request
        $form->handleRequest($request);

        //Principio de negacion
        // Comprobar que se ha submiteado y si es valido
        if(!$form->isSubmitted() || !$form->isValid()){
            //Devolvera un mensaje de error
            return $form;
        }

        $this->em->persist($restaurante);
        $this->em->flush();
        return $restaurante;


    }

    /**
     * @Rest\Get (path="/horarios/{id}")
     * @Rest\View (serializerGroups={"restaurante_horarios"}, serializerEnableMaxDepthChecks=true)
     */

    public function getHorariosRestaurante(Request $request){

        $id = $request->get('id');
        if(!$id){
            return new Response('No id send', Response::HTTP_BAD_REQUEST);
        }
        $restauranteHorarios = $this->restauranteRepository->find($id);
        if(!$restauranteHorarios){
            return new Response('Not found', Response::HTTP_NOT_FOUND);
        }
        return $restauranteHorarios;

    }

    /**
     * @Rest\Post (path="/filtered")
     * @Rest\View (serializerGroups={"restaurante_list"}, serializerEnableMaxDepthChecks= true)
     */

    public function restauranteBy(Request $request){
        $dia = $request->get('dia');
        $hora =  $request->get('hora');
        $idMunicicipio = $request->get('municipio');

        $restaurantes = $this->restauranteRepository->finbByDayAndTime($dia, $hora, $idMunicicipio);
        if(!$restaurantes){
            return new Response('Not Found', Response::HTTP_NOT_FOUND);
        }
        return $restaurantes;

    }

}