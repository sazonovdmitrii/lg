<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PreviewController extends BaseAdminController
{
    /**
     * @Route("/admin/preview", methods={"POST","GET","HEAD"})
     */
    public function preview(
        Request $request,
        PageRepository $pageRepository,
        EntityManagerInterface $entityManager
    ) {
        $page = new Page();
        $page->setContent($request->get('page'));

        $entityManager->persist($page);
        $entityManager->flush();

        $filename = '/elements/preview_' . md5(time()) . '.html';
        $path = $this->get('kernel')->getProjectDir() . '/public' . $filename;

        $previewFile = fopen($path, "w");

        fwrite($previewFile, stripcslashes($page->getContent()));

        fclose($previewFile);

        header('Location: '.$request->getSchemeAndHttpHost() . $filename);
        exit;
    }
}
