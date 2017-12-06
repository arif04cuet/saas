<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfDomainsForm;
use Vokuro\Models\NpfDomains;
use Vokuro\Models\DomainSetup;


class DomaininfosController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function migrateAction()
    {
        if ($this->request->isPost()) {
            try {
                //var_dump($this->request->getPost());
                $src_domain = $this->request->getPost('src_domain', 'striptags');
                $src_db = $this->request->getPost('src_db', 'striptags');
                if ($src_domain && $src_db) {
                    $tmp = $this->migratedomain->migrate_domain(trim($src_domain), trim($src_db));
                    if ($tmp) {
                        $this->flash->success("Successfully migrate domain.");
                    } else {
                        $this->flash->error("Error Occurred in migrating domain.");
                    }
                }


            } catch (Exception $e) {
                $this->flash->error("Error Occurred in migrating domain.");
            }
        }
    }

    public function cleanallAction()
    {
        $this->cleandomain->cleanall_domain();
    }

    public function cloneAction()
    {


        // clone a domain
        if ($this->request->isPost()) {

            try {
                //echo "<pre>";
                //var_dump($this);exit;

                $src_domain = $this->request->getPost('src_domain', 'striptags');
                $clean_domain = $this->request->getPost('clean_domain', 'int');
                $dest_domain = $this->request->getPost('dest_domain', 'striptags');
                if ($clean_domain) {
                    $this->cleandomain->clean_domain(trim($dest_domain));
                }
                $this->clonedomain->clone_domain(trim($src_domain), trim($dest_domain));
                $this->flash->success("Successfully cloned domain.");
            } catch (Exception $e) {
                $this->flash->error("Error Occurred in cloning domain.");
            }
        }
    }

    public function cleanAction()
    {
        if ($this->request->isPost()) {
            try {
                $src_domain = $this->request->getPost('domain', 'striptags');
                $this->cleandomain->clean_domain(trim($src_domain));
                $this->flash->success("Successfully cleaned domain.");
            } catch (Exception $e) {
                $this->flash->error("Error Occurred in cleaning domain.");
            }
        }
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfDomainsForm();
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfDomains', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $npfDomains = NpfDomains::find($parameters);
        if (count($npfDomains) == 0) {
            $this->flash->notice("The search did not find any Domains");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfDomains,
            "limit" => 100,
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

            $domain_type_id = $this->request->getPost('domain_type_id', 'int');

            $npfDomain = new NpfDomains();

            $npfDomain->assign(array(
                'subdomain' => $this->request->getPost('subdomain', 'striptags'),
                'alias' => $this->request->getPost('alias', 'striptags'),
                'domain_type_id' => $domain_type_id,
                'parent_id' => $this->request->getPost('parent_id', 'int'),
                'active' => $this->request->getPost('active', 'int'),
                'is_hosted' => $this->request->getPost('is_hosted', 'int'),
                'site_status' => $this->request->getPost('site_status', 'int'),
                'external_link' => $this->request->getPost('external_link', 'striptags'),
                'template' => $this->request->getPost('template', 'striptags'),
                'sitename_bn' => $this->request->getPost('sitename_bn', 'striptags'),
                'sitename_en' => $this->request->getPost('sitename_en', 'striptags'),
                'site_mail' => $this->request->getPost('site_mail', 'email'),
                'meta_description' => $this->request->getPost('meta_description', 'striptags'),
                'site_theme' => $this->request->getPost('site_theme', 'alphanum'),
                'site_slogan_bn' => $this->request->getPost('site_slogan_bn', 'striptags'),
                'site_slogan_en' => $this->request->getPost('site_slogan_en', 'striptags'),
                'site_footer_bn' => $this->request->getPost('site_footer_bn'),
                'site_footer_en' => $this->request->getPost('site_footer_en'),
                'site_default_language' => $this->request->getPost('site_default_language', 'string'),
                'site_frontpage' => $this->request->getPost('site_frontpage', 'striptags'),
                'site_offline' => $this->request->getPost('site_offline', 'int'),
                'site_mission_bn' => $this->request->getPost('site_mission_bn', 'striptags'),
                'site_mission_en' => $this->request->getPost('site_mission_en', 'striptags'),
                'analytics_id' => $this->request->getPost('analytics_id', 'striptags'),
                'createdby' => $this->getUserId()
            ));


            if (!$npfDomain->save()) {
                $this->flash->error($npfDomain->getMessages());
            } else {

                $domain_id = $npfDomain->id;
                DomainSetup::copyDomainResources($domain_type_id, $domain_id);

                $this->flash->success("Domain was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new NpfDomainsForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfDomain = NpfDomains::findFirstById($id);
        if (!$npfDomain) {
            $this->flash->error("Domain was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {

            $date = new \DateTime();
            $npfDomain->assign(array(
                'subdomain' => $this->request->getPost('subdomain', 'striptags'),
                'alias' => $this->request->getPost('alias', 'striptags'),
                'domain_type_id' => $this->request->getPost('domain_type_id', 'int'),
                'parent_id' => $this->request->getPost('parent_id', 'int'),
                'active' => $this->request->getPost('active', 'int'),
                'is_hosted' => $this->request->getPost('is_hosted', 'int'),
                'site_status' => $this->request->getPost('site_status', 'int'),
                'external_link' => $this->request->getPost('external_link', 'striptags'),
                'template' => $this->request->getPost('template', 'striptags'),
                'sitename_bn' => $this->request->getPost('sitename_bn', 'striptags'),
                'sitename_en' => $this->request->getPost('sitename_en', 'striptags'),
                'site_mail' => $this->request->getPost('site_mail', 'email'),
                'meta_description' => $this->request->getPost('meta_description', 'striptags'),
                'site_theme' => $this->request->getPost('site_theme', 'alphanum'),
                'site_slogan_bn' => $this->request->getPost('site_slogan_bn', 'striptags'),
                'site_slogan_en' => $this->request->getPost('site_slogan_en', 'striptags'),
                'site_footer_bn' => $this->request->getPost('site_footer_bn'),
                'site_footer_en' => $this->request->getPost('site_footer_en'),
                'site_default_language' => $this->request->getPost('site_default_language', 'string'),
                'site_frontpage' => $this->request->getPost('site_frontpage', 'striptags'),
                'site_offline' => $this->request->getPost('site_offline', 'int'),
                'site_mission_bn' => $this->request->getPost('site_mission_bn', 'striptags'),
                'site_mission_en' => $this->request->getPost('site_mission_en', 'striptags'),
                'analytics_id' => $this->request->getPost('analytics_id', 'striptags'),
                'lastmodifiedby' => $this->getUserId(),
                'lastmodified' => $date->format("Y-m-d H:i:s")
            ));

            if (!$npfDomain->save()) {
                $this->flash->error($npfDomain->getMessages());
            } else {

                $this->flash->success("Domain was updated successfully");

                Tag::resetInput();
            }

        }

        $this->view->form = new NpfDomainsForm($npfDomain, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

//        $user = NpfDomains::findFirstById($id);
//        if (!$user) {
//            $this->flash->error("Domain was not found");
//            return $this->dispatcher->forward(array('action' => 'index'));
//        }
//
//        if (!$user->delete()) {
//            $this->flash->error($user->getMessages());
//        } else {
//            $this->flash->success("Domain was deleted");
//        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }
}

