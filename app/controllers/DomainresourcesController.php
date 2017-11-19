<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Models\NpfLookupTypes;
use Vokuro\Models\NpfDomainViews;
use Vokuro\Models\NpfDomainTypes;
use Vokuro\Models\NpfContentTypes;
use Vokuro\Models\NpfViewContents;
use Vokuro\Models\NpfDomainContentTypes;
use Vokuro\Models\NpfDomainResources;
use Vokuro\Models\NpfDomainDefaultResources;

class DomainresourcesController extends ControllerBase
{
    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function setupcontenttypesAction(){

        if ($this->request->isPost()) {
            $t = $this->request->getPost();
            $flg = false;
            foreach($t as $dtid=>$cntids){
                $tt = array_keys($cntids);
                $tt = implode(',',$tt);
                $npfDomainDefaultResources = NpfDomainDefaultResources::findFirst("domain_type_id = ".$dtid);
                $npfDomainDefaultResources->assign(array(
                    'content_type_ids' => $tt,
                ));
                if ($npfDomainDefaultResources->save()) {
                    $flg=true;
                } else {
                    $flg = false;
                }
//                DomainSetup::copyDomainResources($domain_type_id,$domain_id);
            }
            if ($flg) {
                $this->flash->success("Content Type Mapping was updated successfully");
            } else {
                $this->flash->error("Fail to update Content Type Mapping");
            }
        }

        $npfDomainDefaultResources = NpfDomainDefaultResources::find();
        $dt = array();
        foreach($npfDomainDefaultResources as $npfDomainDefaultResource){
            $dt[$npfDomainDefaultResource->domain_type_id] = explode(',',$npfDomainDefaultResource->content_type_ids);
        }
        $contentTypes = NpfContentTypes::find('active=1');
        $domainTypes = NpfDomainTypes::find('id!=9');

        $this->view->contentTypes = $contentTypes;
        $this->view->domainTypes = $domainTypes;
        $this->view->contentMap = $dt;
    }
    public function setupviewsAction(){

        if ($this->request->isPost()) {
            $t = $this->request->getPost();
            $flg = false;
            foreach($t as $dtid=>$vwids){
                $tt = array_keys($vwids);
                $tt = implode(',',$tt);
                $npfDomainDefaultResources = NpfDomainDefaultResources::findFirst("domain_type_id = ".$dtid);
                $npfDomainDefaultResources->assign(array(
                    'view_ids' => $tt,
                ));
                if ($npfDomainDefaultResources->save()) {
                    $flg=true;
                } else {
                    $flg = false;
                }
            }
            if ($flg) {
                $this->flash->success("Views Mapping was updated successfully");
            } else {
                $this->flash->error("Fail to update Views Mapping");
            }
        }

        $npfDomainDefaultResources = NpfDomainDefaultResources::find();
        $dt = array();
        foreach($npfDomainDefaultResources as $npfDomainDefaultResource){
            $dt[$npfDomainDefaultResource->domain_type_id] = explode(',',$npfDomainDefaultResource->view_ids);
        }
        $viewContents = NpfViewContents::find('active=1');
        $domainTypes = NpfDomainTypes::find('id!=9');

        $this->view->viewContents = $viewContents;
        $this->view->domainTypes = $domainTypes;
        $this->view->viewMap = $dt;
    }
    public function setuptaxonomyAction(){

        if ($this->request->isPost()) {
            $t = $this->request->getPost();
            $flg = false;
            foreach($t as $dtid=>$vwids){
                $tt = array_keys($vwids);
                $tt = implode(',',$tt);
                $npfDomainDefaultResources = NpfDomainDefaultResources::findFirst("domain_type_id = ".$dtid);
                $npfDomainDefaultResources->assign(array(
                    'taxonomy_ids' => $tt,
                ));
                if ($npfDomainDefaultResources->save()) {
                    $flg=true;
                } else {
                    $flg = false;
                }
            }
            if ($flg) {
                $this->flash->success("Taxonomy Mapping was updated successfully");
            } else {
                $this->flash->error("Fail to update Taxonomy Mapping");
            }
        }

        $npfDomainDefaultResources = NpfDomainDefaultResources::find();
        $dt = array();
        foreach($npfDomainDefaultResources as $npfDomainDefaultResource){
            $dt[$npfDomainDefaultResource->domain_type_id] = explode(',',$npfDomainDefaultResource->taxonomy_ids);
        }
        $lookupTypes = NpfLookupTypes::find('active=1');
        $domainTypes = NpfDomainTypes::find('id!=9');

        $this->view->lookupTypes = $lookupTypes;
        $this->view->domainTypes = $domainTypes;
        $this->view->taxonomyMap = $dt;
    }
    public function contenttypesAction()
    {

        $domainid = $this->getDomainId();
        $npfDomainResources = NpfDomainResources::findFirst("domain_id = ".$domainid);
        $selCntTypes = array();

        if ($this->request->isPost()) {

            $t = $this->request->getPost();
            $t = array_keys($t);
            $tt = implode(',',$t);

            if ($npfDomainResources===false) {
                $npfDomainResources = new NpfDomainResources();
                $npfDomainResources->assign(array(
                    'domain_id' => $domainid,
                    'content_type_ids' => $tt,
                ));
            }else{
                $npfDomainResources->assign(array(
                    'content_type_ids' => $tt,
                ));
            }
            $selCntTypes = $t;

            if (!$npfDomainResources->save()) {
                $this->flash->error($npfDomainResources->getMessages());
            } else {
                $this->flash->success("Domain Resoureces was updated successfully");
            }
        }else{
            if ($npfDomainResources) {
                $selCntTypes = explode(',',$npfDomainResources->content_type_ids);
            }
        }

        $npfContentTypes = NpfContentTypes::find('is_common=0');
        $t = array();
        foreach($npfContentTypes as $contentType){
            $t[] = array('id'=>$contentType->id,'name'=>$contentType->name,'hname'=>$contentType->human_name);
        }
        $this->view->contentTypes = $t;
        $this->view->selCntTypes = $selCntTypes;
    }
    public function viewsAction()
    {

        $domainid = $this->getDomainId();
        $npfDomainResources = NpfDomainResources::findFirst("domain_id = ".$domainid);
        $selViews = array();

        if ($this->request->isPost()) {

            $t = $this->request->getPost();
            $t = array_keys($t);
            $tt = implode(',',$t);

            if ($npfDomainResources===false) {
                $npfDomainResources = new NpfDomainResources();
                $npfDomainResources->assign(array(
                    'domain_id' => $domainid,
                    'view_ids' => $tt,
                ));
            }else{
                $npfDomainResources->assign(array(
                    'view_ids' => $tt,
                ));
            }
            $selViews = $t;

            if (!$npfDomainResources->save()) {
                $this->flash->error($npfDomainResources->getMessages());
            } else {
                $this->flash->success("Domain Resoureces was updated successfully");
            }
        }else{
            if ($npfDomainResources) {
                $selViews = explode(',',$npfDomainResources->view_ids);
            }
        }

        $npfContentTypes = NpfViewContents::find();
        $t = array();
        foreach($npfContentTypes as $contentType){
            $t[] = array('id'=>$contentType->id,'name'=>$contentType->name,'hname'=>$contentType->human_name);
        }
        $this->view->views = $t;
        $this->view->selViews = $selViews;
    }
    public function taxonomyAction()
    {

        $domainid = $this->getDomainId();
        $npfDomainResources = NpfDomainResources::findFirst("domain_id = ".$domainid);
        $selViews = array();

        if ($this->request->isPost()) {

            $t = $this->request->getPost();
            $t = array_keys($t);
            $tt = implode(',',$t);

            if ($npfDomainResources===false) {
                $npfDomainResources = new NpfDomainResources();
                $npfDomainResources->assign(array(
                    'domain_id' => $domainid,
                    'taxonomy_ids' => $tt,
                ));
            }else{
                $npfDomainResources->assign(array(
                    'taxonomy_ids' => $tt,
                ));
            }
            $selViews = $t;

            if (!$npfDomainResources->save()) {
                $this->flash->error($npfDomainResources->getMessages());
            } else {
                $this->flash->success("Domain Resoureces was updated successfully");
            }
        }else{
            if ($npfDomainResources) {
                $selViews = explode(',',$npfDomainResources->taxonomy_ids);
            }
        }

        $npfContentTypes = NpfLookupTypes::find('is_common=0');
        $t = array();
        foreach($npfContentTypes as $contentType){
            $t[] = array('id'=>$contentType->id,'name'=>$contentType->name,'hname'=>$contentType->description);
        }
        $this->view->views = $t;
        $this->view->selViews = $selViews;
    }
}

