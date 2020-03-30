<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManager;

class SecurityController extends AbstractController
{
    private $em;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->em = $entityManager;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
//        $user = $this->em->getRepository('App:Users')->find(2);
//        echo "<pre>";
//        var_dump($user->getPassword());
//        print_r(get_class_methods($user));
//        die();
//        var_dump($user->getRoles());
//        die();
//        var_dump(get_class($this->em));
//        die();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
