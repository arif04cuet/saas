<?php
namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfTemplateBlocksForm;
use Vokuro\Models\NpfTemplateBlocks;

class TemplateblocksController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfTemplateBlocksForm();
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfTemplateBlocks', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $npfBlocks = NpfTemplateBlocks::find($parameters);
        if (count($npfBlocks) == 0) {
            $this->flash->notice("The search did not find any Template Blocks");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfBlocks,
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

            $domain_id = $this->getDomainId();

            $npfBlocks = new NpfTemplateBlocks();

            $npfBlocks->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'title_bn' => $this->request->getPost('title_bn', 'striptags'),
                'title_en' => $this->request->getPost('title_en', 'striptags'),
                'volt_bn' => $this->request->getPost('volt_bn'),
                'volt_en' => $this->request->getPost('volt_en'),
                'sql' => $this->request->getPost('sql'),
                'css' => $this->request->getPost('css'),
                'js' => $this->request->getPost('js'),
            ));

            if (!$npfBlocks->save()) {
                $this->flash->error($npfBlocks->getMessages());
            } else {

                $this->flash->success("Template Blocks was created successfully");
                $id = $npfBlocks->id;
                $viewname = $npfBlocks->name;
                $template_bn = $this->getTemplateData(
                    $this->request->getPost('volt_bn'),
                    $this->request->getPost('css'),
                    $this->request->getPost('js'));
                $this->renderVoltText($viewname, $viewname.'_'.'template_bn', $template_bn);

                $template_en = $this->getTemplateData(
                    $this->request->getPost('volt_en'),
                    $this->request->getPost('css'),
                    $this->request->getPost('js'));
                $this->renderVoltText($viewname, $viewname.'_'.'template_en', $template_en);

//                Tag::resetInput();
                return $this->response->redirect('templateblocks/edit/'.$id);
            }
        }
//        $uuid = $this->uuid->v4();
//        $this->view->uuid = $uuid;
//        $this->view->uploadPath = $this->getFileUploadPath('npfblock',$uuid);
        $this->view->form = new NpfTemplateBlocksForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfBlocks = NpfTemplateBlocks::findFirstById($id);
        if (!$npfBlocks) {
            $this->flash->error("Template Blocks was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {

            $npfBlocks->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'title_bn' => $this->request->getPost('title_bn', 'striptags'),
                'title_en' => $this->request->getPost('title_en', 'striptags'),
                'volt_bn' => $this->request->getPost('volt_bn'),
                'volt_en' => $this->request->getPost('volt_en'),
                'sql' => $this->request->getPost('sql'),
                'css' => $this->request->getPost('css'),
                'js' => $this->request->getPost('js'),
            ));

            if (!$npfBlocks->save()) {
                $this->flash->error($npfBlocks->getMessages());
            } else {

                $this->flash->success("Template Blocks was updated successfully");

                $viewname = $npfBlocks->name;
                $template_bn = $this->getTemplateData(
                    $this->request->getPost('volt_bn'),
                    $this->request->getPost('css'),
                    $this->request->getPost('js'));
                $this->renderVoltText($viewname, $viewname.'_'.'template_bn', $template_bn);

                $template_en = $this->getTemplateData(
                    $this->request->getPost('volt_en'),
                    $this->request->getPost('css'),
                    $this->request->getPost('js'));
                $this->renderVoltText($viewname, $viewname.'_'.'template_en', $template_en);

//                Tag::resetInput();
                return $this->response->redirect('templateblocks/edit/'.$id);
            }

        }
//        $this->view->uploadPath = $this->getFileUploadPath('npfblock',$npfBlocks->uploadpath);
        $this->view->form = new NpfTemplateBlocksForm($npfBlocks, array('edit' => true));
    }
    private function getTemplateData($v,$c,$j){

        $t = $v;
        $t .= '<style>'.$c.'</style>';
        $t .= '<script>'.$j.'</script>';
        //echo $t;
        return $t;
    }
    private function renderVoltText($viewName,$templateName, $volt_text){
        //Create a compiler
        $compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();
        //Optionally add some options
        $compiler->setOptions(array());

        //Compile a template string returning PHP code
        $tt = $compiler->compileString($volt_text);
        $template_path = $this->config->application->templateUri.'blocks/'.$viewName;

        mkdir($template_path, 0755, true);

        $file = fopen($template_path.'/'.$templateName.".compiled","w");

        fwrite($file, $tt);
        fclose($file);
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

        $user = NpfTemplateBlocks::findFirstById($id);
        if (!$user) {
            $this->flash->error("Blocks was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if (!$user->delete()) {
            $this->flash->error($user->getMessages());
        } else {
            $this->flash->success("Blocks was deleted");
        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }

}

