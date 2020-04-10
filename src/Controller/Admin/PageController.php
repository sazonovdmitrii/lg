<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Service\OnService;
use Doctrine\ORM\EntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Response;

class PageController extends BaseAdminController
{
    /**
     * @var OnService
     */
    private $onService;

    public function __construct(OnService $onService)
    {
        $this->onService = $onService;
    }

    private $_template = 'admin/Page/form.html.twig';

    protected function renderTemplate($actionName, $templatePath, array $parameters = array())
    {
        if ($actionName == 'edit' && $this->request->get('mode')) {
            $templatePath = $this->_template;
        }
        return $this->render($templatePath, $parameters);
    }

    protected function editAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_EDIT);

        $id        = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity    = $easyadmin['item'];

        if ($this->request->isXmlHttpRequest() && $property = $this->request->query->get('property')) {
            $newValue       = 'true' === mb_strtolower($this->request->query->get('newValue'));
            $fieldsMetadata = $this->entity['list']['fields'];

            if (!isset($fieldsMetadata[$property]) || 'toggle' !== $fieldsMetadata[$property]['dataType']) {
                throw new \RuntimeException(sprintf('The type of the "%s" property is not "toggle".', $property));
            }

            $this->updateEntityProperty($entity, $property, $newValue);

            // cast to integer instead of string to avoid sending empty responses for 'false'
            return new Response((int)$newValue);
        }

        $fields = $this->entity['edit']['fields'];

        $editForm   = $this->executeDynamicMethod('create<EntityName>EditForm', array($entity, $fields));
        $deleteForm = $this->createDeleteForm($this->entity['name'], $id);

        $editForm->handleRequest($this->request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->dispatch(EasyAdminEvents::PRE_UPDATE, array('entity' => $entity));

            $this->executeDynamicMethod('preUpdate<EntityName>Entity', array($entity, true));
            $this->executeDynamicMethod('update<EntityName>Entity', array($entity, $editForm));

            $this->dispatch(EasyAdminEvents::POST_UPDATE, array('entity' => $entity));

            $this->onService
                ->setContent([
                        'slug'    => $entity->getSlug(),
                        'content' => $entity->getContent()
                    ]
                )
                ->getData();

            return $this->redirectToReferrer();
        }

        $this->dispatch(EasyAdminEvents::POST_EDIT);

        $parameters = array(
            'form'          => $editForm->createView(),
            'entity_fields' => $fields,
            'entity'        => $entity,
            'delete_form'   => $deleteForm->createView(),
        );

        return $this->executeDynamicMethod('render<EntityName>Template', array('edit', $this->entity['templates']['edit'], $parameters));
    }

    public function copyAction()
    {

        $id     = $this->request->query->get('id');
        $entity = $this->em->getRepository(Page::class)->find($id);

        $page = new Page();
        $page->setContent($entity->getContent());
        $page->setStorage($entity->getStorage());
        $page->setFile($entity->getFile());
        $page->setProductId($entity->getProductId());
        $page->setSlug($entity->getSlug());
        $page->setTitle($entity->getTitle());

        $this->em->persist($page);
        $this->em->flush();

        return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => $this->request->query->get('entity'),
            )
        );
    }
}
