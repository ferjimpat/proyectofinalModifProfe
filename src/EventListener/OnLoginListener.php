<?php

namespace App\EventListener;

use App\Repository\ClienteRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class OnLoginListener
{

    private $repo;
    public function __construct(ClienteRepository  $repo){
        $this->repo = $repo;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event){
        $data = $event->getData();
        $user = $event->getUser();
        if(!$user instanceof UserInterface){
            return;
        }

        foreach ($user->getRoles() as $rol){
            if ($rol == 'ROLE_CLIENTE'){
                $cliente = $this->repo->findOneBy(['user'=>$user->getId()]);
            }
        }
        if($cliente){
            $id_cliente = $cliente->getId();
            $data['cliente']=$id_cliente;
        }

//        $data['user_id'] = $user->getid();
        $data['id'] = $user->getid();
        $event->setData($data);
    }

}