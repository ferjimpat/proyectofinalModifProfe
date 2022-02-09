<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class OnLoginListener
{

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event){
        $data = $event->getData();
        $user = $event->getUser();
        if(!$user instanceof UserInterface){
            return;
        }
        $data['user_id'] = $user->getid();
        $event->setData($data);
    }

}