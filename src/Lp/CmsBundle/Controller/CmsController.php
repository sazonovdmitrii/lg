<?php
namespace App\Lp\CmsBundle\Controller;

use App\Lp\Framework\LpController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Catalog;

class CmsController extends AbstractController
{
    /**
     * @Route("/{slug}", name="cms")
     */
    public function match()
    {
        return $this->render('root/index.html.twig', [
            'controller_name' => 'CmsController',
        ]);
    }
}
