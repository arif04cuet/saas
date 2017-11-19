<?php

namespace Vokuro\Controllers;

class PrivacyController extends ControllerBase
{

    public function indexAction()
    {
    	$this->view->setTemplateBefore('public');
    }
    public function rebuildAction(){
        //Rebuild the ACL with
        $this->acl->rebuild();
    }
}

