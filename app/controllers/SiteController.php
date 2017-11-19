<?php

namespace Vokuro\Controllers;

use Vokuro\Models\NpfDomains;

class SiteController extends SiteControllerBase
{

    public function indexAction()
    {
        $domain_info = (array)$this->getDomain();
        $lang = $this->view->lang;
        $this->view->leftbar = $this->buildRegion($domain_info['id'], $lang, 'left');
        
    }

    public function listAction($name)
    {
        $this->view->leftbar = $this->get_view_content($name);
    }

    public function viewAction($contentType, $id)
    {

        $this->view->leftbar = $this->renderContent($contentType, $id);
    }
}
