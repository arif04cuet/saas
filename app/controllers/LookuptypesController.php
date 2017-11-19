<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfLookupTypesForm;
use Vokuro\Models\NpfLookupTypes;
use Vokuro\Models\NpfDomainResources;


class LookuptypesController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfLookupTypesForm();
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfLookupTypes', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        // check if domain id is 1
        $domainid = $this->getDomainId();
        $cnt_ids = '';
        if($domainid!=1){
            $cnt_ids = $this->getDomainTaxonomy($domainid);
//            echo $cnt_ids;
            if(!empty($cnt_ids)){
                $cnt_ids = " active = 1 AND id IN (".$cnt_ids.")";
//                $cnt_ids = " active = 1";
            }
        }

        if(!isset($parameters['conditions'])){
            $parameters['conditions'] = $cnt_ids;
        }else{
            $parameters['conditions'] .= ' AND '.$cnt_ids;
        }
        $npfLookuptypes = NpfLookupTypes::find($parameters);
        if (count($npfLookuptypes) == 0) {
            $this->flash->notice("The search did not find any Lookup Types");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfLookuptypes,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }
    private function getDomainTaxonomy($domainid){
        $cnt_ids = NpfDomainResources::findFirst("domain_id = '$domainid'");
        if($cnt_ids){
            return $cnt_ids->taxonomy_ids;
        }
        return '';
    }
    /**
     * Creates a Content Type
     *
     */
    public function createAction()
    {
        if ($this->request->isPost()) {

            $npfLookuptypes = new NpfLookupTypes();
            $lookuptypeid = $this->request->getPost('lookuptype_id', 'int');
            $npfLookuptypes->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'description' => $this->request->getPost('description', 'striptags'),
                'lookuptype_id' => $lookuptypeid?$lookuptypeid:0,
                'is_common' => $this->request->getPost('is_common', 'int'),
                'active' => 1,
            ));

            if (!$npfLookuptypes->save()) {
                $this->flash->error($npfLookuptypes->getMessages());
            } else {

                $this->flash->success("Lookup Types was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new NpfLookupTypesForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfLookuptypes = NpfLookupTypes::findFirstById($id);
        if (!$npfLookuptypes) {
            $this->flash->error("Lookup Types was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $lookuptypeid = $this->request->getPost('lookuptype_id', 'int');

            $npfLookuptypes->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'description' => $this->request->getPost('description', 'striptags'),
                'lookuptype_id' => $lookuptypeid?$lookuptypeid:0,
                'is_common' => $this->request->getPost('is_common', 'int'),
                'active' => 1,
            ));

            if (!$npfLookuptypes->save()) {
                $this->flash->error($npfLookuptypes->getMessages());
            } else {

                $this->flash->success("Lookup Types was updated successfully");

                Tag::resetInput();
            }

        }

        $this->view->form = new NpfLookupTypesForm($npfLookuptypes, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

//        $user = NpfLookupTypes::findFirstById($id);
//        if (!$user) {
//            $this->flash->error("Lookup Types was not found");
//            return $this->dispatcher->forward(array('action' => 'index'));
//        }
//
//        if (!$user->delete()) {
//            $this->flash->error($user->getMessages());
//        } else {
//            $this->flash->success("Lookup Types was deleted");
//        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }
}

