<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfWebformsForm;
use Vokuro\Models\NpfWebforms;
use Vokuro\Models\NpfWebformsData;


class WebformsController extends ControllerBase
{

    public function initialize()
    {
//        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfWebformsForm();
    }

    public function searchAction()
    {

        $numberPage = 1;
        $domain = array('forms_domain_id' => $this->getDomainId());
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfWebforms', array_merge($domain, $this->request->getPost()));
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $npfWebforms = NpfWebforms::find($parameters);
        if (count($npfWebforms) == 0) {
            $this->flash->notice("The search did not find any Forms");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfWebforms,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a Content Type
     *
     */
    public function createAction()
    {
        $this->view->flds = '[{"cssClass":"input_text","required":"undefined","values":"First Name"},{"cssClass":"textarea","required":"undefined","values":"Bio"},{"cssClass":"checkbox","required":"undefined","title":"Whats on your pizza?","values":{"2":{"value":"Extra Cheese","baseline":"undefined"},"3":{"value":"Beef","baseline":"undefined"}}}]';
        $this->view->form = new NpfWebformsForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {
        $npfWebforms = NpfWebforms::findFirstById($id);

        if (!$npfWebforms) {
            $this->flash->error("Form was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        $flds = unserialize($npfWebforms->form_fields);
        /*echo '<pre>';
        print_r($npfWebforms->toArray());
        exit;*/

        $this->view->flds = json_encode($flds);

        $this->view->form = new NpfWebformsForm($npfWebforms, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

        $form = NpfWebforms::findFirstById($id);
        if (!$form) {
            $this->flash->error("Web Form was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if (!$form->delete()) {
            $this->flash->error($form->getMessages());
        } else {
            $this->flash->success("Web Form was deleted");
        }

        //return $this->dispatcher->forward(array('action' => 'index'));
        return $this->response->redirect('webforms');
    }

    public function getformAction()
    {
        $this->view->disable();
        $fake_db_vals = Array('form_structure' => '[{"cssClass":"input_text","required":"undefined","values":"First Name"},{"cssClass":"textarea","required":"undefined","values":"Bio"},{"cssClass":"checkbox","required":"undefined","title":"What\'s on your pizza?","values":{"2":{"value":"Extra Cheese","baseline":"undefined"},"3":{"value":"Beef","baseline":"undefined"}}}]');
        $form = new $this->formbuilder($fake_db_vals);
        $form->render_json();
    }

    public function saveformAction()
    {


        $this->view->disable();
        $msg = "Invalid post data.";
        if ($this->request->isPost()) {
            $npfWebforms = new NpfWebforms();

            $flds = serialize($this->request->getPost('frmb'));
            $npfWebforms->assign(array(
                'forms_domain_id' => $this->getDomainId(),
                'machine_name' => $this->request->getPost('machine_name'),
                'active' => $this->request->getPost('active'),
                'form_title' => $this->request->getPost('form_title'),
                'action_type' => $this->request->getPost('action_type'),
                'action_path' => $this->request->getPost('action_path'),
                'form_msg' => $this->request->getPost('form_msg'),
                'form_email' => $this->request->getPost('form_email'),
                'header_bn' => $this->request->getPost('header_bn'),
                'header_en' => $this->request->getPost('header_en'),
                'footer_bn' => $this->request->getPost('footer_bn'),
                'footer_en' => $this->request->getPost('footer_en'),
                'form_fields' => $flds
            ));


            if (!$npfWebforms->save()) {
                $msg = "failed";
            } else {

                $msg = "success";
            }
            print_r($npfWebforms);
            exit;
        }
        $response = new Response();
        $response->setContent($msg);
        return $response;

    }

    public function updateformAction()
    {
        $this->view->disable();
        $msg = "Invalid post data.";

        if ($this->request->isPost()) {


            //$npfWebforms = new NpfWebforms();
            $npfWebforms = NpfWebforms::findFirstById($this->request->getPost('id'));

            //print_r($npfWebforms);exit;
            $flds = serialize($this->request->getPost('frmb'));
            $npfWebforms->assign(array(
                'active' => $this->request->getPost('active'),
                'form_title' => $this->request->getPost('form_title'),
                'action_type' => $this->request->getPost('action_type'),
                'action_path' => $this->request->getPost('action_path'),
                'form_msg' => $this->request->getPost('form_msg'),
                'form_email' => $this->request->getPost('form_email'),
                'header_bn' => $this->request->getPost('header_bn'),
                'header_en' => $this->request->getPost('header_en'),
                'footer_bn' => $this->request->getPost('footer_bn'),
                'footer_en' => $this->request->getPost('footer_en'),
                'form_fields' => $flds,
            ));

            if (!$npfWebforms->save()) {
                $msg = "failed";
            } else {
                $msg = "success";
            }

        }
        $response = new Response();
        //$response->setContentType('application/json', 'UTF-8');
        $response->setContent($msg);
        return $response;
    }

    public function listAction()
    {
        $machineName = $this->dispatcher->getParam('machine_name');
        $domainId = $this->getDomainId();
        $list = NpfWebformsData::find();
        echo '<pre>';
        print_r($list);
        exit;
        $numberPage = 1;
        $domain = array('domain_id' => $this->getDomainId());
        $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfFeedback', array_merge($domain, $this->request->get()));
        $this->persistent->searchParams = $query->getParams();
        $numberPage = $this->request->getQuery("page", "int");


        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }
        $parameters['order'] = 'created desc';
        $npfFeedback = NpfFeedback::find($parameters);
        if (count($npfFeedback) == 0) {
            $this->flash->notice("The search did not find any Feedback");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfFeedback,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }
}