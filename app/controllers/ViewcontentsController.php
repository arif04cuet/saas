<?php
namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\View;
use Vokuro\Forms\NpfViewContentForm;
use Vokuro\Models\NpfViewContents;
use Vokuro\Models\NpfDomainResources;

class ViewcontentsController extends ControllerBase
{
    public function initialize()
    {
//        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfViewContentForm();
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfViewContents', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }
        $parameters['order'] = 'created desc';

        $domainid = $this->getDomainId();
        $vw_ids = '';
        if($domainid!=1){
            $vw_ids = $this->getDomainViews($domainid);
            if(!empty($vw_ids)){
                $vw_ids = "AND id IN (".$vw_ids.")";
            }
        }

        if(!isset($parameters['conditions'])){
            $parameters['conditions'] =' active = 1 '.$vw_ids;
        }else{
            $parameters['conditions'].=' AND active = 1 '.$vw_ids;
        }

        $npfViewContents = NpfViewContents::find($parameters);
        if (count($npfViewContents) == 0) {
            $this->flash->notice("The search did not find any View Content");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }
        //var_dump($npfViewContents);
        $paginator = new Paginator(array(
            "data" => $npfViewContents,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }
    public function listajaxAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfViewContents', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $domainid = $this->getDomainId();
        $vw_ids = '';
        if($domainid!=1){
            $vw_ids = $this->getDomainViews($domainid);
            if(!empty($vw_ids)){
                $vw_ids = "AND id IN (".$vw_ids.")";
            }
        }

        if(!isset($parameters['conditions'])){
            $parameters['conditions'] =' active = 1 '.$vw_ids;
        }else{
            $parameters['conditions'].=' AND active = 1 '.$vw_ids;
        }

        $npfViewContents = NpfViewContents::find($parameters);
        if (count($npfViewContents) == 0) {
            $this->flash->notice("The search did not find any View Content");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }
        //var_dump($npfViewContents);
        $paginator = new Paginator(array(
            "data" => $npfViewContents,
            "limit" => 100,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);

        $this->view->setTemplateBefore('ajax');
    }

    private function getDomainViews($domainid){
        $vw_ids = NpfDomainResources::findFirst("domain_id = '$domainid'");
        if($vw_ids){
            return $vw_ids->view_ids;
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
            $uuid = $this->uuid->v4();
            $npfViewContent = new NpfViewContents();
            $viewname = $this->request->getPost('name', 'striptags');
            $domainid = $this->getDomainId();
            $npfViewContent->assign(array(
//                'id' => $uuid,
                'name' => $this->request->getPost('name', 'striptags'),
                'human_name' => $this->request->getPost('human_name', 'striptags'),
                'template_bn' => $this->request->getPost('template_bn'),
                'template_en' => $this->request->getPost('template_en'),
                'header_bn' => $this->request->getPost('header_bn'),
                'header_en' => $this->request->getPost('header_en'),
                'footer_bn' => $this->request->getPost('footer_bn'),
                'footer_en' => $this->request->getPost('footer_en'),
                'sql_query' => $this->request->getPost('sql_query'),
                'css' => $this->request->getPost('css'),
                'js' => $this->request->getPost('js'),
                'is_right_side_bar' => $this->request->getPost('is_right_side_bar','int'),
                'is_pagination' => $this->request->getPost('is_pagination','int'),
                'uploadpath' => $this->request->getPost('uploadpath'),
                'active' => '1',
            ));
            if (!$npfViewContent->save()) {

                $this->flash->error($npfViewContent->getMessages());
            } else {

                $this->flash->success("View created successfully");

//                $this->flash->success("View updated successfully");

                $viewname = $npfViewContent->name;
                $template_bn = $this->getTemplateData(  $this->request->getPost('header_bn'),
                    $this->request->getPost('template_bn'),
                    $this->request->getPost('footer_bn'),
                    $this->request->getPost('css'),
                    $this->request->getPost('js'));
                $this->renderVoltText($viewname, $viewname.'_'.'template_bn', $template_bn);

                $template_en = $this->getTemplateData(  $this->request->getPost('header_en'),
                    $this->request->getPost('template_en'),
                    $this->request->getPost('footer_en'),
                    $this->request->getPost('css'),
                    $this->request->getPost('js'));
                $this->renderVoltText($viewname, $viewname.'_'.'template_en', $template_en);

                return $this->response->redirect('viewcontents/edit/'.$uuid);
            }
        }
        $uppath = $this->uuid->v4();
        $this->view->uploadpath_id = $uppath;
        $this->view->uploadPath = $this->getViewUploadPath($uppath);
        $this->view->form = new NpfViewContentForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfViewContent = NpfViewContents::findFirstById($id);
//        var_dump($npfViewContent);
        if (!$npfViewContent) {
            $this->flash->error("View was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {

            $npfViewContent->assign(array(
//                'name' => $this->request->getPost('name', 'striptags'),
                'human_name' => $this->request->getPost('human_name', 'striptags'),
                'template_bn' => $this->request->getPost('template_bn'),
                'template_en' => $this->request->getPost('template_en'),
                'header_bn' => $this->request->getPost('header_bn'),
                'header_en' => $this->request->getPost('header_en'),
                'footer_bn' => $this->request->getPost('footer_bn'),
                'footer_en' => $this->request->getPost('footer_en'),
                'sql_query' => $this->request->getPost('sql_query'),
                'css' => $this->request->getPost('css'),
                'js' => $this->request->getPost('js'),
                'is_right_side_bar' => $this->request->getPost('is_right_side_bar','int'),
                'is_pagination' => $this->request->getPost('is_pagination','int'),
//                'uploadpath' => $this->request->getPost('uploadpath'),
            ));

            if (!$npfViewContent->save()) {
                $this->flash->error($npfViewContent->getMessages());
            } else {

                $this->flash->success("View updated successfully");

                $viewname = $npfViewContent->name;

                $template_bn = $this->getTemplateData(  $this->request->getPost('header_bn'),
                                                        $this->request->getPost('template_bn'),
                                                        $this->request->getPost('footer_bn'),
                                                        $this->request->getPost('css'),
                                                        $this->request->getPost('js'));
                $this->renderVoltText($viewname, $viewname.'_'.'template_bn', $template_bn);

                $template_en = $this->getTemplateData(  $this->request->getPost('header_en'),
                                                        $this->request->getPost('template_en'),
                                                        $this->request->getPost('footer_en'),
                                                        $this->request->getPost('css'),
                                                        $this->request->getPost('js'));
                $this->renderVoltText($viewname, $viewname.'_'.'template_en', $template_en);

                return $this->response->redirect('viewcontents/edit/'.$id);
            }

        }

        $this->view->uploadPath = $this->getViewUploadPath($npfViewContent->uploadpath);
        $this->view->form = new NpfViewContentForm($npfViewContent, array('edit' => true));
    }
    private function getTemplateData($h,$v,$f,$c,$j){

        $t = $h;
        $t .= $v;
        $t .= $f;
        $t .= '<style>'.$c.'</style>';
        $t .= '<script>'.$j.'</script>';
        //echo $t;
        return $t;
    }
    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

//        $user = NpfViewContents::findFirstById($id);
//        if (!$user) {
//            $this->flash->error("View was not found");
//            return $this->dispatcher->forward(array('action' => 'index'));
//        }
//
//        if (!$user->delete()) {
//            $this->flash->error($user->getMessages());
//        } else {
//            $this->flash->success("View deleted");
//        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }

    private function renderVoltText($viewName,$templateName, $volt_text){
        //Create a compiler
        $compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();
        //Optionally add some options
        $compiler->setOptions(array());

        //Compile a template string returning PHP code
        $tt = $compiler->compileString($volt_text);
        $template_path = $this->config->application->templateUri.'views/'.$viewName;

        mkdir($template_path, 0755, true);

        $file = fopen($template_path.'/'.$templateName.".compiled","w");

        fwrite($file, $tt);
        fclose($file);
    }

}
