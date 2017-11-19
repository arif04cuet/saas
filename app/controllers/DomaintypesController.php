<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfDomainTypesForm;
use Vokuro\Models\NpfDomainTypes;


class DomaintypesController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfDomainTypesForm();
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfDomainTypes', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $npfDomainTypes = NpfDomainTypes::find($parameters);
        if (count($npfDomainTypes) == 0) {
            $this->flash->notice("The search did not find any Domain Types");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfDomainTypes,
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
        if ($this->request->isPost()) {

            $npfDomainType = new NpfDomainTypes();

            $parent_id = $this->request->getPost('parent_id', 'int');
            $npfDomainType->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'parent_id' => $parent_id?$parent_id:null,
            ));

            if (!$npfDomainType->save()) {
                $this->flash->error($npfDomainType->getMessages());
            } else {

                $this->flash->success("Domain Type was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new NpfDomainTypesForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfDomainType = NpfDomainTypes::findFirstById($id);
        if (!$npfDomainType) {
            $this->flash->error("Domain Type was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $parent_id = $this->request->getPost('parent_id', 'int');
            $npfDomainType->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'parent_id' => $parent_id?$parent_id:null,
            ));

            if (!$npfDomainType->save()) {
                $this->flash->error($npfDomainType->getMessages());
            } else {

                $this->flash->success("Domain Type was updated successfully");

                Tag::resetInput();
            }

        }

        $this->view->form = new NpfDomainTypesForm($npfDomainType, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

//        $npfDomainType = NpfDomainTypes::findFirstById($id);
//        if (!$npfDomainType) {
//            $this->flash->error("Domain Type was not found");
//            return $this->dispatcher->forward(array('action' => 'index'));
//        }
//
//        if (!$npfDomainType->delete()) {
//            $this->flash->error($npfDomainType->getMessages());
//        } else {
//            $this->flash->success("Domain Type was deleted");
//        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }

}

