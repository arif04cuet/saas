<?php

namespace Vokuro\Controllers;

class AboutController extends ControllerBase
{

    public function indexAction()
    {
    	$this->view->setTemplateBefore('public');
    }
    public function renderAction() {
        $filename = $this->config->application->actionUri.'/test.php';
        $vars = array();
        $vars['this'] = $this;
        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }
        ob_start();
        include $filename;
        $output = ob_get_clean();
        echo $output;
    }

    private function test2(){
        echo 'private test2';
    }
    public function test3(){
        echo 'public test3';
    }
}

