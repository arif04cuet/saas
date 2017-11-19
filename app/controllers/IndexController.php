<?php

namespace Vokuro\Controllers;

use Vokuro\Models\Contents;


class IndexController extends ControllerBase
{

    public function indexAction()
    {
//    	$this->view->setTemplateBefore('public');
        return $this->response->redirect('');
    }
//    public function contentAction(){
//        $this->view->setTemplateBefore('private');
//        $t = Contents::listModel();
//        if(count($t)>0){
//            $this->view->formName = $t[0]->name;
//            $this->view->formHName = $t[0]->human_name;
//            $this->view->formFields = unserialize($t[0]->flds);
//            //var_dump($this->view->formFields);
//        }
//    }
//	public function contentTypeAction(){
//        $this->view->setTemplateBefore('private');
//		// get the params and print
//        if ($this->request->isPost()) {
//            var_dump($this->request->getPost());
//        }
//	}



}

