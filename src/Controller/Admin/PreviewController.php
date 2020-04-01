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
        if($pageId = $request->get('id')) {
            $page = $pageRepository->find($pageId);
        }

        $page->setContent($request->get('page'));

        $filename = '/elements/preview_' . md5(time()) . '.html';

        $page->setFile($filename);
        $page->setStorage($request->get('storage'));

        $entityManager->persist($page);
        $entityManager->flush();

        $path = $this->get('kernel')->getProjectDir() . '/public' . $filename;

        $previewFile = fopen($path, "w");

        fwrite($previewFile, stripcslashes($page->getContent()));

        fclose($previewFile);

        header('Location: '.$request->getSchemeAndHttpHost() . $filename);
        exit;
    }

    /**
     * @Route("/admin/save", methods={"POST","GET","HEAD"})
     */
    public function save(
        Request $request,
        PageRepository $pageRepository,
        EntityManagerInterface $entityManager
    ) {
        die('adsfasdfasd-----');
    }
}
