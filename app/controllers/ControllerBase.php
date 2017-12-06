<?php

namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller,
    Phalcon\Mvc\Url,
    Phalcon\Http\Response,
    Phalcon\Mvc\Dispatcher;

use Vokuro\Models\NpfDomains;
use Vokuro\Models\NpfOfficeUsers;
use Vokuro\Models\AuditLog;

/**
 * ControllerBase
 *
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {


        $controllerName = $dispatcher->getControllerName();

        $identity = $this->auth->getIdentity();

        $this->setViewTemplate();
        $this->view->profile = $identity;
        $this->view->domainname = $this->getDomainName();


        //Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName)) {

            //Get the current identity
            if (!$this->checkDomainAccess($dispatcher)) {
                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index'
                ));
                return false;
            }

//            var_dump($identity);
            //If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {

                $this->flash->notice('You don\'t have access to this module: private');

                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index'
                ));
                return false;
            }

            //Check if the user have permission to the current option
            $actionName = $dispatcher->getActionName();
            //var_dump($identity['profile']);
            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {

                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

                if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
                    $dispatcher->forward(array(
                        'controller' => $controllerName,
                        'action' => 'index'
                    ));
                } else {
                    $dispatcher->forward(array(
                        'controller' => 'user_control',
                        'action' => 'index'
                    ));
                }

                return false;
            }

        }


        if ($this->session->has("content-flash-msg")) {
            $msg = $this->session->get("content-flash-msg");
            switch ($msg['type']) {
                case "success":
                    $this->flash->success($msg['msg']);
                    break;
                case "fail":
                    $this->flash->error($msg['msg']);
                    break;
            }
            $this->session->remove("content-flash-msg");
        }

    }

    public function log($text)
    {
        //logging
        $log = new AuditLog();
        $log->assign(
            array(
                'user_id' => $this->getUserId(),
                'changes' => $text,
                'ipAddress' => $_SERVER['REMOTE_ADDR'],
                'domain_id' => $this->getDomainId()
            )
        );

        $log->save();
    }

    public function checkDomainAccess()
    {
        if (!$this->ifCheckDomainAccess()) {
            //
            if ($this->getUserDomainId() != $this->getDomainId()) {
                $this->session->set("content-flash-msg",
                    array("type" => "notice", "msg" => "You don\'t have access to domain.")
                );

                return false;
            }
        }
        return true;
    }

    public function setViewTemplate()
    {
        $profile = $this->getUserProfile();
        $template = 'public';
        if ($profile == 'Administrators') {
            $template = 'sysadmin';
        } else if ($profile == 'Master Trainers') {
            $template = 'sysadmin';
        } else if ($profile == 'Site Admin') {
            $template = 'contentmanager';
        } else if ($profile == 'Content Manager') {
            $template = 'contenteditor';
        }
        $this->view->setTemplateBefore($template);
    }

    public function getUserProfile()
    {
        $identity = $this->auth->getIdentity();
        return $identity['profile'];
    }

    public function getUserProfileId()
    {
        $identity = $this->auth->getIdentity();
//        var_dump($identity);
        return $identity['profile_id'];
    }

    public function isAdministrator()
    {
        $identity = $this->auth->getIdentity();
        if ($identity['profile'] == 'Administrators') {
            return true;
        }
        return false;
    }

    public function ifCheckDomainAccess()
    {
        $identity = $this->auth->getIdentity();
        if ($identity['profile'] == 'Administrators') {
            return true;
        }
        if ($identity['profile'] == 'Master Trainers') {
            return true;
        }
        return false;
    }

    public function getDomainId()
    {
        $domain_name = $this->getDomainName();
        $domain_name = $domain_name == 'localhost' ? 'cabinet.gov.bd' : $domain_name;
        $domain = NpfDomains::findFirst("subdomain = '" . $domain_name . "'");

        return $domain->id;
    }

	public function getDomain()
    {
        $domain_name = $this->getDomainName();
        $domain = NpfDomains::findFirst("subdomain = '" . $domain_name . "'");
        return $domain;
    }
	
    public function getOfficeInfo()
    {
        $identity = $this->auth->getIdentity();
        $office = NpfOfficeUsers::findFirst("user_id = '" . $identity['id'] . "'");

        return $office->office;
    }

    public function getDomainName()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function getUuid()
    {
        return $this->uuid->v4();
    }

    public function getUserId()
    {
        $identity = $this->auth->getIdentity();
        return $identity['id'];
    }

    public function getUserDomainId()
    {
        $identity = $this->auth->getIdentity();
        return $identity['domain_id'];
    }

    public function getDomainPath()
    {
        $url_path = 'http://' . $this->getDomainName() . $this->config->application['baseUri'];
        return $url_path;
    }

    public function ajaxResponse($response)
    {
        //Create a response instance
        $response = new Response();
        //Set the content of the response
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($response);
        //Return the response
        return $response;
    }

    public function getFileUploadPath($contentType, $uuid)
    {
        $uuid = str_replace("-", "_", $uuid);
        $uploadPath = $contentType . '/' . $uuid . '/';
        $domainName = $this->getDomainName();
        return $domainName . '/' . $uploadPath;
    }

    public function getViewUploadPath($uuid)
    {
        $uuid = str_replace("-", "_", $uuid);
        $uploadPath = 'view/' . $uuid . '/';
        return $uploadPath;
    }


}