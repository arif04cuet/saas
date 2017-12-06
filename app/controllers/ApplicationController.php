<?php

namespace Vokuro\Controllers;

use Vokuro\Models\AuditLog;
use Vokuro\Models\NpfDomains;

class ApplicationController extends ControllerBase
{

    public function initialize()
    {
        $identity = $this->auth->getIdentity();
        if (empty($identity))
            return $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'logout'
            ));
    }

    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }

    public function createAction()
    {

        $insData = $_POST;
        if ($_POST['courseName'] == '' || $_POST['txtStuName'] == '' || $_POST['txtDateOfBirthYear'] == '') {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?message=Pls fill up all required fields');
            exit;
        }
        $insData = $_POST;
        $insData['created'] = date("Y-m-d : h:i:s");
        $insData['imgMAS'] = '';

        if ($this->request->hasFiles() == true) {
            $uploadPath = dirname(dirname(dirname(dirname(__FILE__)))) . '/sites/default/files/files/nimc.portal.gov.bd/applications/';
            foreach ($this->request->getUploadedFiles() as $file) {
                $fileName = md5(uniqid(rand(), true)) . '-' . strtolower($file->getname());
                $insData[$file->getKey()] = $fileName;
                $file->moveTo($uploadPath . $fileName);
            }
        }


        $columns = implode(", ", array_keys($insData));
        //$escaped_values = array_map('mysql_real_escape_string', array_values($insData));
        $values = implode(',', array_map(function ($value) {

            return !is_numeric($value) ? '"' . $value . '"' : $value;

        }, array_values($insData)));

        //$values = implode(", ", array_values($insData));

        $sql = "INSERT INTO `npf_online_courses`($columns) VALUES ($values)";
        $this->db->execute($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?message=success');
        exit;
    }

    /* =============== common save form by tt==========================*/
    public function createformAction()
    {

        $insData = $_POST;
        if ($_POST['courseName'] == '' || $_POST['applicantName'] == '' || $_POST['txtDateOfBirthYear'] == '') {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?message=Pls fill up all required fields');
            exit;
        }

        $insData = $_POST;
		
        $insData['created'] = date("Y-m-d : h:i:s");
        $insData['imgMAS'] = '';
		$domainId = $_POST['domain_id'];
        $domain = NpfDomains::findFirst("id = $domainId");
        $domain_id = $domain->id;
        $domain_subdomain = $domain->subdomain;
        if ($this->request->hasFiles() == true) {
            $uploadPath = dirname(dirname(dirname(dirname(__FILE__)))) . "/npfadmin/app/cache/files/$domain_subdomain/applications/";
            foreach ($this->request->getUploadedFiles() as $file) {
                $fileName = md5(uniqid(rand(), true)). '-' . strtolower($file->getname());
                $insData[$file->getKey()] = $fileName;
                $file->moveTo($uploadPath . $fileName);
            }
        }

		
        $fields = serialize($insData);
        $domainId = $_POST['domain_id'];

        $createDateTime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `npf_online_applications` (`domain_id`, `fields`, `created`) VALUES ( $domainId, '$fields', '$createDateTime')";
        $this->db->execute($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?message=success');
        exit;
    }


    public function listAction()
    {
         if ($this->getDomainName() != 'nimc.portal.gov.bd')
             exit;
        $rpp = 20;
        $numberPage = $this->request->getQuery("page", "int", 1);
        $offset = ($numberPage * $rpp) - $rpp;
        $sql = "select * from npf_online_courses order by created DESC limit $offset,$rpp";
        $data = $this->db->query($sql);
        $data = $data->fetchAll($data);
        $this->view->list = $data;
    }
    /* ========= common list form by tt========*/
    public function listFormAction()
    {
        $rpp = 20;
        $numberPage = $this->request->getQuery("page", "int", 1);
        $offset = ($numberPage * $rpp) - $rpp;
        $domainId = $this->getDomainId();
        $sql = "select * from npf_online_applications where domain_id = '$domainId'  order by created DESC limit $offset,$rpp";
        $data = $this->db->query($sql);
        $data = $data->fetchAll($data);
        $this->view->listForm = $data;

    }

    public function showAction($id)
    {
        $sql = "select * from npf_online_courses where id=$id limit 1";
        $application = $this->db->query($sql);
        $application = $application->fetchAll($application);
        $this->view->application = $application[0];
        $this->view->uploadPath = '/sites/default/files/files/nimc.portal.gov.bd/applications/';

    }
      /* ========= common show form by tt========*/
    public function showFormAction($id)
    {
        $domain = $this->getDomain();
        $domain_id = $domain->id;
        $domain_subdomain = $domain->subdomain;
        $sql = "select * from npf_online_applications where id=$id and domain_id = '$domain_id' limit 1";
        $application = $this->db->query($sql);
        $application = $application->fetchAll($application);
        $this->view->applications = $application[0];
        $this->view->uploadPath = "/sites/default/files/files/$domain_subdomain/applications/";
        /*============= ===============*/
        $mapping = array('6192' => 'showForm','6224' => 'showFormBCS');
        $view_name = $mapping["$domain_id"];
        $this->view->pick("application/$view_name");

    }

    public function deleteAction($id)
    {
        $sql = "delete from npf_online_courses where id=$id limit 1";
        $this->db->execute($sql);
        return $this->response->redirect('npfadmin/application/list');
    }
    /* ===================== Delete form by ttt========================================= */
    public function deleteFormAction($id)
    {
        $sql = "delete from npf_online_applications where id=$id limit 1";
        $this->db->execute($sql);
        return $this->response->redirect($SERVER['HTTPREFERER']);
    }

    public function logsAction()
    {
      
        $rpp = 100;
        $numberPage = $this->request->getQuery("page", "int", 1);
        $offset = ($numberPage * $rpp) - $rpp;
        $domainId = $this->getDomainId();
        $conditions = array(
            "domain_id = $domainId",
            'order' => 'change_time desc',
            "limit" => array('number' => $rpp, 'offset' => $offset)
        );

        if ($this->getDomainId() == 1) {
            $conditions = array(
                'order' => 'change_time desc',
                "limit" => array('number' => $rpp, 'offset' => $offset)
            );
        }

        $logs = AuditLog::find($conditions);
        $this->view->logs = $logs;

    }
}
