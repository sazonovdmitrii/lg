<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class PageController extends BaseAdminController
{
    private $_template = 'admin/Page/form.html.twig';

    protected function renderTemplate($actionName, $templatePath, array $parameters = array())
    {
        if($actionName == 'edit') {
            $templatePath = $this->_template;
        }
        return $this->render($templatePath, $parameters);
    }
}
