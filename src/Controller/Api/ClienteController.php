<?php

namespace App\Controller\Api;

use App\Form\Type\ClienteFormType;
use App\Repository\ClienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route ("/cliente")
 */
class ClienteController extends AbstractApiController
{

    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em, ClienteRepository $repo)
    {

        $this->em = $em;
        $this->repo = $repo;

    }

    /**
     * @Rest\Post (path="")
     * @Rest\View (serializerGroups={"cliente"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function  createCliente(Request $request){
        $form = $this->buildForm(ClienteFormType::class);
        $form->handleRequest($request);
        if(!$form->isSubmitted() || !$form->isValid()){
            return new Response('Bad data', Response::HTTP_BAD_REQUEST);
        }
        $cliente = $form->getData();
        $this->em->persist($cliente);
        $this->em->flush();
        return $cliente;
    }

    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"cliente"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function  getCliente(Request $request){
        $id_cliente= $request->get('id');
        $cliente = $this->repo->find($id_cliente);
        if(!$cliente ){
            return new Response('No hay resultados', Response::HTTP_NOT_FOUND);
        }




        return $cliente;
    }

    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View (serializerGroups={"cliente"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function  updateCliente(Request $request){
        $id_cliente= $request->get('id');
        $cliente = $this->repo->find($id_cliente);
        if(!$cliente ){
            return new Response('No hay resultados', Response::HTTP_NOT_FOUND);
        }
        $form = $this->buildForm(ClienteFormType::class,$cliente, ['method'=> $request->getMethod()]);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            return new Response('Bad data', Response::HTTP_BAD_REQUEST);
        }

        $cliente = $form->getData();
        $this->em->persist($cliente);
        $this->em->flush();
        return $cliente;


    }







}