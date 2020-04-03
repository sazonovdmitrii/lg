<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends AbstractController
{
    /**
     * @Route("/landing/{slug}", name="landing")
     */
    public function index($slug)
    {
        return $this->render('root/index.html.twig', [
            'controller_name' => 'RootController',
        ]);
    }
}
