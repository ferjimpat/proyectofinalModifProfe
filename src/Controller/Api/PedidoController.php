<?php

namespace App\Controller\Api;


use App\Entity\CantidadPlatosPedido;
use App\Entity\Cliente;
use App\Entity\Estado;
use App\Entity\Pedido;
use App\Form\Type\CantidadPlatosPedidoFormType;
use App\Form\Type\PedidoFormType;
use App\Repository\PedidoRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Rest\Route("/pedido")
 */
class PedidoController extends AbstractApiController
{
    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em, PedidoRepository $repo)
    {

        $this->em = $em;
        $this->repo = $repo;

    }

    /**
     * @Rest\Post (path="")
     * @Rest\View (serializerGroups={"pedido"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function  createPedido(Request $request){


        $platos_arr= [];
        $platos = $request->get('platos');
        $form = $this->buildForm(CantidadPlatosPedidoFormType::class);
        foreach ($platos as $plato){
            $form->submit($plato);
            if(!$form->isSubmitted() || !$form->isValid()){
                return $form;
            }
            /** @var CantidadPlatosPedido $cantidad */
            $cantidad = $form->getData();

            $this->em->persist($cantidad);
            $this->em->flush();
            $platos_arr[]=$cantidad;
        }

        $pedido =$request->get('pedido') ;
        $form = $this->buildForm(PedidoFormType::class);
        $form->submit($pedido);


        if(!$form->isSubmitted() || !$form->isValid()){
            return $form;
        }
        /** @var Pedido $pedido */
        $pedido = $form->getData();
        $this->em->persist($pedido);
        foreach ($platos_arr as $cant){
            $pedido->addPlatosYCantidad($cant);

            $this->em->persist($cant);
            $this->em->flush();
        }


        $this->em->flush();

        return $pedido;
    }

    /**
     * @Rest\Get (path="/{idClient}")
     * @Rest\View (serializerGroups={"pedido"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function getPedidosCliente(Request $request){
        $id = $request->get('idClient');
        $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($id);
        if(!$cliente){
            throw new NotFoundHttpException('El cliente no existe');
        }
        $pedidos = $this->repo->findBy(['cliente'=> $cliente]);
        return $pedidos;



    }
    /**
     * @Rest\Patch  (path="/{idPedido}")
     * @Rest\View (serializerGroups={"pedido"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function cancelarPedido(Request $request){
        $id = $request->get('idPedido');
        $pedido = $this->repo->find($id);
        if(!$pedido){
            throw new NotFoundHttpException('El cliente no existe');
        }
        //Comprobamos que el pedido tiene un hueco de 24 entre el dia de envio y el de cancelacion
        $fechaPedido = $pedido->getFechaEntrega();
        $today = new \DateTime();
        $interval= $fechaPedido->diff($today);
        if(($interval->days * 24) < 24){
            return new Response('No se puede cancelar el pedido', 200);
        }
        $estado = $this->getDoctrine()->getRepository(Estado::class)->find(3);
        $pedido->setEstado($estado);
        $this->em->persist($estado);
        $this->em->flush();
        return new Response('Pedido cancelado', 200);



    }

}