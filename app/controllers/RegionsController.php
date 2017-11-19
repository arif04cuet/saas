<?php
namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfRegionForm;
use Vokuro\Models\NpfRegion;

class RegionsController extends ControllerBase
{
    private function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }
//    public function getmethodsAction(){
//        //$this->view->setTemplateBefore('private');
//        $dir    = './../app/controllers';
//        $files1 = scandir($dir);
//        $controllers = array();
//        foreach($files1 as $file){
//            if($this->endsWith($file,'Controller.php')){
//
//                $controllers[] = "Vokuro\\Controllers\\".str_replace('.php', '', $file);
//            }
//        }
//        var_dump($controllers);
//
//        $actions = array();
//        foreach($controllers as $controller){
//            $foo = new $controller;
//            $class = new \ReflectionClass($foo);
//            $methods = $class->getMethods();
//            foreach($methods as $method){
//                if($this->endsWith($method->name,'Action')){
//                    $actions[''.$controller][] = $method->name;
//                }
//            }
//        }
//        var_dump($actions);
//    }
    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new NpfRegionForm();
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfRegion', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $npfRegion = NpfRegion::find($parameters);
        if (count($npfRegion) == 0) {
            $this->flash->notice("The search did not find any Region");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfRegion,
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

            $npfRegion = new NpfRegion();

            $npfRegion->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'description' => $this->request->getPost('description', 'striptags'),
            ));

            if (!$npfRegion->save()) {
                $this->flash->error($npfRegion->getMessages());
            } else {

                $this->flash->success("Region was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new NpfRegionForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfRegion = NpfRegion::findFirstById($id);
        if (!$npfRegion) {
            $this->flash->error("Region was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {

            $npfRegion->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'description' => $this->request->getPost('description', 'striptags'),
            ));

            if (!$npfRegion->save()) {
                $this->flash->error($npfRegion->getMessages());
            } else {

                $this->flash->success("Region was updated successfully");

                Tag::resetInput();
            }

        }

        $this->view->form = new NpfRegionForm($npfRegion, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

//        $user = NpfRegion::findFirstById($id);
//        if (!$user) {
//            $this->flash->error("Region was not found");
//            return $this->dispatcher->forward(array('action' => 'index'));
//        }
//
//        if (!$user->delete()) {
//            $this->flash->error($user->getMessages());
//        } else {
//            $this->flash->success("Region was deleted");
//        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }

}

