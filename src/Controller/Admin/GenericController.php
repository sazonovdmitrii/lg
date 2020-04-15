<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use App\Service\RequestFilterService;
use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;

class GenericController extends BaseAdminController
{
    private $_template = 'admin/Generic/form.html.twig';

    protected function renderTemplate($actionName, $templatePath, array $parameters = array())
    {
        return $this->render($this->_template, $parameters);
    }
}
