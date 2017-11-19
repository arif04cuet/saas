<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfOfficesForm;
use Vokuro\Models\NpfOfficeUsers;
use Vokuro\Models\NpfOffices;


class OfficesController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfOfficesForm();
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfOffices', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $npfOffices = NpfOffices::find($parameters);
        if (count($npfOffices) == 0) {
            $this->flash->notice("The search did not find any Office");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfOffices,
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

            $npfOffice = new NpfOffices();


            $npfOffice->assign(array(
                'name_bn' => $this->request->getPost('name_bn', 'striptags'),
                'name_en' => $this->request->getPost('name_en', 'striptags'),
                'address_bn' => $this->request->getPost('address_bn', 'striptags'),
                'address_en' => $this->request->getPost('address_en', 'striptags'),
                'phone' => $this->request->getPost('phone', 'striptags'),
                'email' => $this->request->getPost('email', 'striptags'),
                'domain_id' => $this->request->getPost('domain_id', 'int'),
            ));

            if (!$npfOffice->save()) {
                $this->flash->error($npfOffice->getMessages());
            } else {

                $this->flash->success("Office was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new NpfOfficesForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfOffice = NpfOffices::findFirstById($id);
        if (!$npfOffice) {
            $this->flash->error("Office Type was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {

            $npfOffice->assign(array(
                'name_bn' => $this->request->getPost('name_bn', 'striptags'),
                'name_en' => $this->request->getPost('name_en', 'striptags'),
                'address_bn' => $this->request->getPost('address_bn', 'striptags'),
                'address_en' => $this->request->getPost('address_en', 'striptags'),
                'phone' => $this->request->getPost('phone', 'striptags'),
                'email' => $this->request->getPost('email', 'striptags'),
                'domain_id' => $this->request->getPost('domain_id', 'int'),
            ));

            if (!$npfOffice->save()) {
                $this->flash->error($npfOffice->getMessages());
            } else {

                $this->flash->success("Office was updated successfully");

                Tag::resetInput();

            }

        }
        $this->view->office = $npfOffice;
        $this->view->form = new NpfOfficesForm($npfOffice, array('edit' => true));
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function assignuserAction()
    {
        $id = $this->request->getPost('id', 'int');
        $npfOffice = NpfOffices::findFirstById($id);
        if (!$npfOffice) {
            $this->flash->error("Office Type was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            //todo: check first if the user is already assigned to the office

            $npfUserOffice = new NpfOfficeUsers();
            $npfUserOffice->assign(array(
                'user_id' => $this->request->getPost('user_id', 'striptags'),
                'office_id' => $id,
            ));

            if (!$npfUserOffice->save()) {
                $this->flash->error($npfOffice->getMessages());
            } else {

                $this->flash->success("Office User was updated successfully");
                return $this->response->redirect('offices/edit/'.$id);
            }

        }
        $this->view->office = $npfOffice;
        $this->view->form = new NpfOfficesForm($npfOffice, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

//        $npfOffice = NpfOffices::findFirstById($id);
//        if (!$npfOffice) {
//            $this->flash->error("Office was not found");
//            return $this->dispatcher->forward(array('action' => 'index'));
//        }
//
//        if (!$npfOffice->delete()) {
//            $this->flash->error($npfOffice->getMessages());
//        } else {
//            $this->flash->success("Office was deleted");
//        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }

}

