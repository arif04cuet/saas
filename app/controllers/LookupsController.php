<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfLookupsForm;
use Vokuro\Models\NpfLookups;
use Vokuro\Models\NpfLookupTypes;
use Vokuro\Models\NpfDomainResources;


class LookupsController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfLookupsForm();
    }
    public function listAction()
    {
        $domainid = $this->getDomainId();
        $cnt_ids = '';
        if($domainid!=1){
            $cnt_ids = $this->getDomainTaxonomy($domainid);
            if(!empty($cnt_ids)){
                $cnt_ids = " active = 1 AND id IN (".$cnt_ids.") OR is_common=1";
//                $cnt_ids = " active = 1";
            }
        }
//        echo $cnt_ids;
        //
        $npfLookuptypes = NpfLookupTypes::find($cnt_ids);
        $this->view->lookupTypes = $npfLookuptypes;
    }
    private function getDomainTaxonomy($domainid){
        $cnt_ids = NpfDomainResources::findFirst("domain_id = '$domainid'");
//        $cnt_ids = NpfDomainResources::findFirst();
        if($cnt_ids){
            return $cnt_ids->taxonomy_ids;
        }
        return '';
    }
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfLookups', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfLookups', $this->request->get());
            $this->persistent->searchParams = $query->getParams();
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }
        $domainid = $this->getDomainId();
        //$parameters->andWhere("domain_id=".$domainid);
        //$parameters['conditions'] .= " AND domain_id=".$domainid;

        $is_common = NpfLookupTypes::findFirstById($this->request->get('lookuptype_id'));
        if (!$is_common->is_common)
            $parameters['conditions'] .= " AND domain_id=" . $domainid;

        
		$parameters['order'] = "created desc";
		
//        var_dump($parameters);
        $npfLookups = NpfLookups::find($parameters);
        if (count($npfLookups) == 0) {
            $this->flash->notice("The search did not find any Lookup");
//            return $this->dispatcher->forward(array(
//                "action" => "index"
//            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfLookups,
            "limit" => 100,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
        $lookuptype_id = $this->request->get('lookuptype_id','int');
        $this->view->lookuptype_id = $lookuptype_id;
    }

    /**
     * Creates a Content Type
     *
     */
    public function createAction()
    {
        $npfLookup = new NpfLookups();
        if ($this->request->isPost()) {

//            $npfLookup = new NpfLookups();
            $parent_id = $this->request->getPost('parent_id', 'int');
            $npfLookup->assign(array(
                'domain_id' => $this->getDomainId(),
                'name_bn' => $this->request->getPost('name_bn', 'striptags'),
                'name_en' => $this->request->getPost('name_en', 'striptags'),
                'lookuptype_id' => $this->request->getPost('lookuptype_id', 'int'),
                'parent_id' => ($parent_id?$parent_id:null),
                'weight' => $this->request->getPost('weight', 'int'),
                'createdby' => $this->getUserId(),
                'lastmodifiedby' => $this->getUserId(),
            ));

            if (!$npfLookup->save()) {
                $this->flash->error($npfLookup->getMessages());
            } else {

                $this->flash->success("Lookup was created successfully");

                Tag::resetInput();
            }
        }

        $npfLookup->assign(array(
//                'domain_id' => $this->getDomainId(),
                'name_bn' => '',
                'name_en' => '',
                'lookuptype_id' => $this->request->get('lookuptype_id', 'int'),
//                'parent_id' => null,
                'weight' => 1,
            ));


        $this->view->form = new NpfLookupsForm($npfLookup);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        //$npfLookup = NpfLookups::findFirst('id='.$id.' AND domain_id='.$this->getDomainId());
        $npfLookup = NpfLookups::findFirst('id='.$id);
        if (!$npfLookup) {
            $this->flash->error("Lookup was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $parent_id = $this->request->getPost('parent_id', 'int');
            $npfLookup->assign(array(
                'name_bn' => $this->request->getPost('name_bn', 'striptags'),
                'name_en' => $this->request->getPost('name_en', 'striptags'),
                'lookuptype_id' => $this->request->getPost('lookuptype_id', 'int'),
                'parent_id' => ($parent_id?$parent_id:null),
                'weight' => $this->request->getPost('weight', 'int'),
                'lastmodifiedby' => $this->getUserId(),
            ));

            if (!$npfLookup->save()) {
                $this->flash->error($npfLookup->getMessages());
            } else {

                $this->flash->success("Lookup was updated successfully");

                Tag::resetInput();
            }

        }

        $this->view->parentid = $npfLookup->parent_id;
        $this->view->form = new NpfLookupsForm($npfLookup, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

        /*$user = NpfLookups::findFirstById($id);
        if (!$user) {
            $this->flash->error("Lookup was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if (!$user->delete()) {
            $this->flash->error($user->getMessages());
        } else {
            $this->flash->success("Lookup was deleted");
        }

        return $this->dispatcher->forward(array('action' => 'index'));*/
    }



}

