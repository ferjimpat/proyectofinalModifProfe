<?php

namespace App\Tasks;

use App\Repository\ComentarioRepository;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spatie\Async\Task;

class PuntuacionTask extends  Task
{
    private $rest;
    private $repo;
    private $em;
    private $repoComentario;
    public function  __construct( $rest, EntityManagerInterface $em,
                                  RestauranteRepository $repo,
                                    ComentarioRepository $repoComentario
    ){
        $this->rest = $rest;
        $this->em = $em;
        $this->repo = $repo;
        $this->repoComentario = $repoComentario;

    }
    public function configure()
    {
        // TODO: Implement configure() method.
    }

    public function run()
    {
        $puntuaciones = $this->repoComentario->findBy(['restaurante'=> $this->rest]);
    }
}