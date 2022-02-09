<?php

namespace App\Controller\Api;


use App\Entity\User;
use App\Form\Type\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * @Rest\Route ("/user")
 */
class UserController extends AbstractApiController
{
    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em, UserRepository $repo){
        $this->em = $em;
        $this->repo =$repo;
    }

    /**
     * @Rest\Post (path="/create")
     * @Rest\View (serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */

    public function createUser(Request $request, UserPasswordHasherInterface $passwordHasher){
        $user = $request->get('user');
        $rol = $request->get('rol');
        //Comprobacion de si viene bien o no el request
        $form = $this->buildForm(UserFormType::class);
        $form->submit($user);
        if(!$form->isValid() || !$form->isSubmitted()){
            return $form;
        }
        /** @var User $newuser */
        $newuser = $form->getData();
        $role[] = $rol;
        $newuser->setRoles($role);
        $hashedPassword = $passwordHasher->hashPassword(
          $newuser,
          $user['password']
        );
        $newuser->setPassword($hashedPassword);
        $this->em->persist($newuser);
        $this->em->flush();

        return $newuser;

    }



}