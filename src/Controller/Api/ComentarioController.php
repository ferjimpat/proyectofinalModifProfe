<?php

namespace App\Controller\Api;

use App\Entity\Comentario;
use App\Form\Type\ComentarioFormType;
use App\Repository\ComentarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Rest\Route ("/comentario")
 */
class ComentarioController extends AbstractApiController
{

    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em, ComentarioRepository $repo){
        $this->em = $em;
        $this->repo = $repo;
    }

    /**
     * @Rest\Post (path="")
     * @Rest\View (serializerGroups={"comentario"}, serializerEnableMaxDepthChecks=true)
     */

    public function createComentario(Request $request){
        $comentario = new Comentario();
        $form =$this->buildForm(ComentarioFormType::class, $comentario);
        $form->handleRequest($request);
        if(!$form->isSubmitted() || !$form->isValid()){
            return new Response('Datos incorrectos', Response::HTTP_BAD_REQUEST);
        }

        $restaurante = $comentario->getRestaurante();
        $id = $restaurante->getId();
        $media = $this->repo->findPuntuacionRestaurante($id);
        $puntos = $media[0];

        $restaurante->setValoracionMedia($puntos['media']);
        $this->em->persist($restaurante);
        $this->em->persist($comentario);
        $this->em->flush();

        return $comentario;

    }

}