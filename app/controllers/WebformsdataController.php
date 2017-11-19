<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfWebformsForm;
use Vokuro\Models\NpfWebforms;
use Vokuro\Models\NpfWebformsData;


class WebformsdataController extends ControllerBase
{

    public function initialize()
    {
        //$this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {

    }

    public function listAction()
    {

        $machineName = $this->dispatcher->getParam('machine_name');
        $numberPage = 1;
        $domain = array('forms_domain_id' => $this->getDomainId(), 'machine_name' => $machineName);
        $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfWebformsData', array_merge($domain, $this->request->get()));
        $this->persistent->searchParams = $query->getParams();
        $numberPage = $this->request->getQuery("page", "int");


        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }
        $parameters['order'] = 'created desc';
        $list = NpfWebformsData::find($parameters);
        if (count($list) == 0) {
            $this->flash->notice("The search did not find any data");
            return $this->dispatcher->forward(array(
                'controller' => 'webforms',
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $list,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
        $this->view->machine_name = $machineName;

    }

    public function viewAction()
    {
        $machineName = $this->dispatcher->getParam('machine_name');
        $id = $this->dispatcher->getParam('id');
        $item = NpfWebformsData::findFirstById($id);
        if (!$item) {
            $this->flash->error("Lookup was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }
        $this->view->item = $item->getFields();
        $this->view->mn = $machineName;
    }
}