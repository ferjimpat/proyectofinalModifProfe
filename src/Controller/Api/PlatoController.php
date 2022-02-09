<?php

namespace App\Controller\Api;


use App\Entity\Alergeno;
use App\Entity\Restaurante;
use App\Form\Type\PlatoFormType;
use App\Repository\PlatoRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Rest\Route ("/plato")
 */
class PlatoController extends AbstractApiController
{

    private $platoRepository;
    private $em;

    public function __construct(PlatoRepository $platoRepository, EntityManagerInterface $em){
        $this->em = $em;
        $this->platoRepository = $platoRepository;

    }


    /**
     * @Rest\Post (path="")
     * @Rest\View (serializerGroups={"plato"}, serializerEnableMaxDepthChecks=true)
     */

    public function createPlato(Request $request){
        $form = $this->buildForm(PlatoFormType::class );
        $form->handleRequest($request);
        if(!$form->isSubmitted() || !$form->isValid()){
            return new Response('Bad data', Response::HTTP_BAD_REQUEST);
        }
        $plato = $form->getData();
        $this->em->persist($plato);
        $this->em->flush();
        return $plato;
    }

    /**
     * @Rest\Get (path="/{idRest}")
     * @Rest\View (serializerGroups={"plato"}, serializerEnableMaxDepthChecks=true)
     */

    public function getPlatosRestaurante(Request $request){
        $id_rest = $request->get('idRest');
        $restaurante = $this->getDoctrine()->getRepository(Restaurante::class)->find($id_rest);
        if(!$restaurante){
            throw new NotFoundHttpException('No existe el restaurante');
        }
        $platos = $this->platoRepository->findBy(['restaurante'=>$restaurante]);

        if(!$platos){
            throw new NotFoundHttpException('No existen platos para el restaurante');
        }
        return $platos;
    }

    /**
     * @Rest\Post(path="/alergeno")
     * @Rest\View (serializerGroups={"plato"}, serializerEnableMaxDepthChecks= true)
     */

    public function restauranteAddCategoria(Request $request){
        $res = $request->get('plato');
        $alergenos = $request->get('alergenos');
        $plato = $this->platoRepository->find($res);
        foreach ($alergenos as $al){
            $alergeno =$this->getDoctrine()->getRepository(Alergeno::class)->find($al);
            if(!$alergeno){
                return new Response('Not found', Response::HTTP_NOT_FOUND);
            }
            $plato->addAlergeno($alergeno);
        }
        $this->em->persist($plato);
        $this->em->flush();
        return $plato;
    }





}