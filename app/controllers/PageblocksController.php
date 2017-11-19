<?php
namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\NpfBlocksForm;
use Vokuro\Models\NpfBlocks;
use Vokuro\Models\NpfRegion;

class PageblocksController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction()
    {
        $domain_id = $this->getDomainId();

        $this->view->regions = NpfRegion::find();
        $this->view->bblocks = NpfBlocks::find(array(
            "domain_id = ".$domain_id,
            "order" => "region_id,weight"
        ));

        $this->view->url = $this->getDomainPath();
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfBlocks', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $npfBlocks = NpfBlocks::find($parameters);
        if (count($npfBlocks) == 0) {
            $this->flash->notice("The search did not find any Blocks");
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

            $npfBlocks = new NpfBlocks();

            $npfBlocks->assign(array(
                'title_bn' => $this->request->getPost('title_bn', 'striptags'),
                'title_en' => $this->request->getPost('title_en', 'striptags'),
                'body_bn' => $this->request->getPost('body_bn'),
                'body_en' => $this->request->getPost('body_en'),
                'more' => $this->request->getPost('more','string'),
                'weight' => 0,
                'region_id' => 0,
                'domain_id' => $domain_id,
                'template_block_name' => $this->request->getPost('template_block_name', 'striptags'),
            ));

            if (!$npfBlocks->save()) {
                $this->flash->error($npfBlocks->getMessages());
            } else {

                $this->flash->success("Blocks was created successfully");

                Tag::resetInput();
//                return $this->response->redirect('pageblocks/edit/'.$id);
            }
        }
        $uuid = $this->uuid->v4();
        $this->view->uuid = $uuid;
        $this->view->uploadPath = $this->getFileUploadPath('npfblock',$uuid);
        $this->view->form = new NpfBlocksForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfBlocks = NpfBlocks::findFirstById($id);
        if (!$npfBlocks) {
            $this->flash->error("Blocks was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {

            $npfBlocks->assign(array(
                'title_bn' => $this->request->getPost('title_bn', 'striptags'),
                'title_en' => $this->request->getPost('title_en', 'striptags'),
                'body_bn' => $this->request->getPost('body_bn'),
                'body_en' => $this->request->getPost('body_en'),
                'more' => $this->request->getPost('more','string'),
                'template_block_name' => $this->request->getPost('template_block_name', 'striptags'),
            ));

            if (!$npfBlocks->save()) {
                $this->flash->error($npfBlocks->getMessages());
            } else {

                $this->flash->success("Blocks was updated successfully");


                Tag::resetInput();
//                return $this->response->redirect('pageblocks/edit/'.$id);
            }

        }
        $this->view->uploadPath = $this->getFileUploadPath('npfblock',$npfBlocks->uploadpath);
        $this->view->form = new NpfBlocksForm($npfBlocks, array('edit' => true));
//        var_dump($this->view->form);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function saveAjaxAction()
    {

        $a_result = "started";
        $data = [];
        if ($this->request->isPost() == true) {

            // Check whether the request was made with Ajax
            if ($this->request->isAjax() == true)
            {
                $this->view->disable();
                $data = $this->request->getPost('blcks');
                foreach($data as $blck){
                    $tmp = NpfBlocks::updateBlock($blck[0],$blck[1],$blck[2]);
                    if(false)
                    {
                        $a_result = "failed";
                        break;
                    }
                }
                $a_result = "success";
            }else{
                $a_result = "invalid";
            }
        }
//Create a response instance
        $response = new Response();
        //Set the content of the response
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode(array("result"=>$a_result)));//json_encode(array("result"=>$data)));
        //Return the response
        return $response;
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

        $user = NpfBlocks::findFirstById($id);
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

