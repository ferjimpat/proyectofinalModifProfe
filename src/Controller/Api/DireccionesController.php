<?php

namespace App\Controller\Api;


use App\Entity\Cliente;
use App\Form\Type\ClienteFormType;
use App\Form\Type\DireccionFormType;
use App\Repository\DireccionRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Rest\Route ("/direcciones")
 */
class DireccionesController extends  AbstractApiController
{

    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em, DireccionRepository  $repo)
    {

        $this->em = $em;
        $this->repo = $repo;

    }

    /**
     * @Rest\Post (path="")
     * @Rest\View (serializerGroups={"direcciones_cliente"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function  createDireccion(Request $request){
        $form = $this->buildForm(DireccionFormType::class);
        $form->handleRequest($request);
        if(!$form->isSubmitted() || !$form->isValid()){
            return new Response('Bad data', Response::HTTP_BAD_REQUEST);
        }
        $direccion = $form->getData();
        $this->em->persist($direccion);
        $this->em->flush();
        return $direccion;
    }

    /**
     * @Rest\Get (path="/{idCliente}")
     * @Rest\View (serializerGroups={"direcciones_cliente"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function  getCliente(Request $request){
        $id_cliente = $request->get('idCliente');

        $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($id_cliente);
        if(!$cliente ){
            return new Response('No hay resultados', Response::HTTP_NOT_FOUND);
        }
        $direcciones =$this->repo->findBy(['cliente'=> $cliente]);
        if(!$direcciones){
            throw new NotFoundHttpException('No existen direcciones asociadas al cliente');
        }
        return $cliente;
    }

    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View (serializerGroups={"direcciones_cliente"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function  updateDireccion(Request $request){
        $id_direccion= $request->get('id');
        $direccion = $this->repo->find($id_direccion);
        if(!$direccion ){
            return new Response('No existe la direccione', Response::HTTP_BAD_REQUEST);
        }
        $form = $this->buildForm(DireccionFormType::class,$direccion, ['method'=> $request->getMethod()]);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            return new Response('Bad data', Response::HTTP_BAD_REQUEST);
        }

        $direccion = $form->getData();
        $this->em->persist($direccion);
        $this->em->flush();
        return $direccion;


    }

    /**
     * @Rest\Delete (path="/{id}")
     * @Rest\View (serializerEnableMaxDepthChecks=true)
     *
     */

    public function deleteDireccion(Request $request){
        $id_direccion = $request->get('id');
        $direccion = $this->repo->find($id_direccion);

        if(!$direccion){
            throw new NotFoundHttpException('No existe la direccion ');
        }
        $this->em->remove($direccion);
        $this->em->flush();
        return new Response('Eliminado',Response::HTTP_OK);
    }





}