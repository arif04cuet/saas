<?php

namespace Vokuro\Controllers;

class AboutController extends ControllerBase
{

    public function indexAction()
    {
    	//$this->view->setTemplateBefore('public');
    }

    private function test2(){
        echo 'private test2';
    }
    public function test3(){
        echo 'public test3';
    }
}