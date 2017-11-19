<?php

namespace Vokuro\Controllers;

class ApplicationController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }

    public function createAction()
    {

        $insData = $_POST;

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

    public function listAction()
    {
        $rpp = 20;
        $numberPage = $this->request->getQuery("page", "int", 1);
        $offset = ($numberPage * $rpp) - $rpp;

        $sql = "select * from npf_online_courses order by created limit $offset,$rpp";
        $data = $this->db->query($sql);
        $data = $data->fetchAll($data);

        $this->view->list = $data;

    }

    public function showAction($id)
    {

        $sql = "select * from npf_online_courses where id=$id limit 1";
        $application = $this->db->query($sql);
        $application = $application->fetchAll($application);
        $this->view->application = $application[0];
        $this->view->uploadPath ='/sites/default/files/files/nimc.portal.gov.bd/applications/';

    }
    public function deleteAction($id)
    {
        $sql = "delete from npf_online_courses where id=$id limit 1";
        $this->db->execute($sql);
        return $this->response->redirect('npfadmin/application/list');
    }

}

