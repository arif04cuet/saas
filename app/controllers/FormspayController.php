<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfFormspayForm;
use Vokuro\Models\NpfFormspay;

class FormspayController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfFormspayForm();
    }

    public function listAction()
    {
        $npfFormspay = NpfFormspay::find();
        $this->view->formspay = $npfFormspay;
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfFormspay', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfFormspay', $this->request->get());
            $this->persistent->searchParams = $query->getParams();
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $npfFormspay = NpfFormspay::find($parameters);
        if (count($npfFormspay) == 0) {
            $this->flash->notice("The search did not find any Form");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfFormspay,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }

    public function showAction($id)
    {
        $npfFormspay = NpfFormspay::findFirst('id='.$id.' AND domain_id='.$this->getDomainId());
        if (!$npfFormspay) {
            $this->flash->error("Lookup was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        $show_val = "<h2>".$npfFormspay->form_name."</h2>";


        $form_fields_arr = unserialize($npfFormspay->form_fields); //$npfFormspay->form_fields;
        $show_val .= "<table  align='center' class='table table-bordered table-striped'>";
        foreach ($form_fields_arr as $Key => $Value)
        {
            if($Key != "ct_captcha")
            {
                $show_val .= "<tr>";
                    if(substr($Key, 0, 1) == "q")
                    {
                        $Key = "প্রশ্ন";
                    }
                    else if(substr($Key, 0, 1) == "a")
                    {
                        $Key = "উত্তর";
                    }

                    $show_val .= "<td>".$Key."</td>";
                    $show_val .= "<td>".$Value."</td>";

                $show_val .= "<tr>";
            }
        }

        $show_val .= "</table>";
        //$show_val .= "<br />".implode("#",$form_fields_arr);

        $this->view->setVar("show_val",$show_val);
    }

    public function insertformAction()
    {
        $this->view->disable();
        $msg = "Invalid post data.";

        if ($this->request->isPost()) {
            $npfForms = new NpfFormspay();

            //echo $_SERVER["REQUEST_URI"];exit;//npfadmin/formspay/insertform?form_name=testing_view
            $arr_uri = explode("=",$_SERVER["REQUEST_URI"]);

            /*
            echo "gg:".$arr_uri[1];
            print_r($this->request->getPost());
            exit;
            */
            //print_r($_SESSION);
            /*
            echo $this->request->getPost("ct_captcha");
            echo $_SESSION['securimage_code_disp']['default'];
            exit;
            */

            $flds = serialize($this->request->getPost());
            $npfForms->assign(array(
                'domain_id' => $this->getDomainId(),
                'form_name' => $arr_uri[1],
                'form_fields' => $flds,
                'useragent' => $_SERVER['HTTP_USER_AGENT'],
                'userip' => $_SERVER['REMOTE_ADDR'],
            ));

            if($this->request->getPost("ct_captcha") != $_SESSION['securimage_code_disp']['default'])
            {
                $msg = "captcha";
            }
            else
            {
                if(!$npfForms->save())
                {
                    $msg = "failed";
                } else {
                    $msg = "success";
                }
            }
        }

        $response = new Response();
        //$response->setContentType('application/json', 'UTF-8');
        $response->setContent($msg);
        return $response;
	}

}