<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    \Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\View;
use Vokuro\Forms\ContentTypeForm;
use Vokuro\Models\NpfContentTypes;
use Vokuro\Models\Contents;
use Vokuro\Models\NpfLookupTypes;
use Vokuro\Models\NpfDomainResources;


class ContenttypeController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
        $this->tag->setTitle("Content Type");

    }
    public function listAction()
    {
        $domainid = $this->getDomainId();
        $cnt_ids = '';
        if($domainid!=1){
            $cnt_ids = $this->getDomainContentTypes($domainid);
            if(!empty($cnt_ids)){
                $cnt_ids = " active = 1 AND id IN (".$cnt_ids.")";
            }
        }
        //
        $npfContenttypes = NpfContentTypes::find($cnt_ids);
        $this->view->contentTypes = $npfContenttypes;
    }
    public function listajaxAction()
    {
        $domainid = $this->getDomainId();
        $cnt_ids = '';
        if($domainid!=1){
            $cnt_ids = $this->getDomainContentTypes($domainid);
            if(!empty($cnt_ids)){
                $cnt_ids = " active = 1 AND id IN (".$cnt_ids.")";
            }
        }
        //
        $npfContenttypes = NpfContentTypes::find($cnt_ids);
        $this->view->contentTypes = $npfContenttypes;
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);

        $this->view->setTemplateBefore('ajax');
        //$this->view->pick('ajax');
    }
    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new ContentTypeForm();
    }

    /**
     * Searches for NpfContentTypes
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\NpfContentTypes', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        // get domain id

        // check if domain id is 1
        $domainid = $this->getDomainId();
        $cnt_ids = '';
        if($domainid!=1){
            $cnt_ids = $this->getDomainContentTypes($domainid);
            if(!empty($cnt_ids)){
                $cnt_ids = " active = 1 AND is_common = 0 AND id IN (".$cnt_ids.")";
            }
        }

        if(!isset($parameters['conditions'])){
            $parameters['conditions'] = $cnt_ids;
        }else{
//            $parameters['conditions'] .= ' AND '.$cnt_ids;
        }
        $npfContentTypes = NpfContentTypes::find($parameters);
        if (count($npfContentTypes) == 0) {
            $this->flash->notice("The search did not find any Content Types");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $npfContentTypes,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    private function getDomainContentTypes($domainid){
        $cnt_ids = NpfDomainResources::findFirst("domain_id = '$domainid'");
        if($cnt_ids){
            return $cnt_ids->content_type_ids;
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

            $contentTypeName = $this->request->getPost('name', 'string');

            $flds = $this->request->getPost('fld');

            Contents::createContentTypeTable($contentTypeName,$flds);
            Contents::createContentTypeTable($contentTypeName.'_version',$flds);

            $ser_flds = serialize($flds);

            $sql_query = $this->request->getPost('sql_query');
            $sql_query = $this->getDefaultSql($contentTypeName,$sql_query, $flds);
            $sql_query = serialize($sql_query);
            $domainid = $this->getDomainId();
            $npfContentTypes = new NpfContentTypes();
            $npfContentTypes->assign(array(
                'name' => $contentTypeName,
                'human_name' => $this->request->getPost('human_name', 'string'),
                'flds' => $ser_flds,
                'volt_template_bn' => $this->request->getPost('volt_template_bn'),
                'volt_template_en' => $this->request->getPost('volt_template_en'),
                'css' => $this->request->getPost('css'),
                'js' => $this->request->getPost('js'),
                'sql_query' => $sql_query,
                'active' => '1',
                'use_title' => $this->request->getPost('use_title', 'int'),
                'use_body' => $this->request->getPost('use_body', 'int'),
                'is_common' => $this->request->getPost('is_common', 'int'),
                'icon' => $this->request->getPost('icon', 'string'),
                'domain_id' => $domainid,
                'is_right_side_bar' => $this->request->getPost('is_right_side_bar', 'int'),
            ));

            if (!$npfContentTypes->save()) {
                $this->flash->error($npfContentTypes->getMessages());
            } else {
                // render the volt file and transfer that in the drupal template dir
                $template_bn = $this->getTemplateData( $this->request->getPost('volt_template_bn'),
                    $this->request->getPost('css'),
                    $this->request->getPost('js'));
                $this->renderVoltText($contentTypeName."_bn", $template_bn);

                $template_en = $this->getTemplateData( $this->request->getPost('volt_template_en'),
                    $this->request->getPost('css'),
                    $this->request->getPost('js'));
                $this->renderVoltText($contentTypeName."_en", $template_en);

                $this->flash->success("Content Type was created successfully");
                return $this->dispatcher->forward(array(
                    "action" => "index"
                ));
            }

        }
        $this->tag->setTitle("Content Type : Create");
        $this->view->contentTypes = Contents::get_sys_fld_type_names();
        $this->view->cntntTypes = NpfContentTypes::find();
        $this->view->lookuptbls = NpfLookupTypes::find();
        $this->view->form = new ContentTypeForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $npfContentTypes = NpfContentTypes::findFirstById($id);
        if (!$npfContentTypes) {
            $this->flash->error("Content Type was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {

            $contentTypeName = $this->request->getPost('name', 'string');
            $newflds = $this->request->getPost('fld');
            $flds = serialize($newflds);

            $sql_query = $this->request->getPost('sql_query');
            $sql_query = $this->getDefaultSql($contentTypeName,$sql_query, $flds);
            $sql_query = serialize($sql_query);

            $oldflds = unserialize($npfContentTypes->flds);

            Contents::alterContentTypeTable($npfContentTypes->name, $oldflds, $newflds);
            Contents::alterContentTypeTable($npfContentTypes->name.'_version', $oldflds, $newflds);

            $list_flds = '';
            $chkfld = $this->request->getPost('chkfld', 'string');
            if($chkfld){
                $tt = array_keys($this->request->getPost('chkfld', 'string'));
                $list_flds = implode(',',$tt);
            }
            $domainid = $this->getDomainId();
            $npfContentTypes->assign(array(
                'human_name' => $this->request->getPost('human_name', 'string'),
                'flds' => $flds,
                'volt_template_bn' => $this->request->getPost('volt_template_bn'),
                'volt_template_en' => $this->request->getPost('volt_template_en'),
                'css' => $this->request->getPost('css'),
                'js' => $this->request->getPost('js'),
                'sql_query' => $sql_query,
                'use_title' => $this->request->getPost('use_title', 'int'),
                'use_body' => $this->request->getPost('use_body', 'int'),
                'is_common' => $this->request->getPost('is_common', 'int'),
                'icon' => $this->request->getPost('icon', 'string'),
                'domain_id' => $domainid,
                'is_right_side_bar' => $this->request->getPost('is_right_side_bar', 'int'),
                'icon' => $this->request->getPost('icon', 'string'),
                'list_fields' => $list_flds,
            ));

            if (!$npfContentTypes->save()) {
                $this->flash->error($npfContentTypes->getMessages());
            } else {

                $template_bn = $this->getTemplateData( $this->request->getPost('volt_template_bn'),
                                                $this->request->getPost('css'),
                                                $this->request->getPost('js'));
                $this->renderVoltText($contentTypeName."_bn", $template_bn);

                $template_en = $this->getTemplateData( $this->request->getPost('volt_template_en'),
                                                $this->request->getPost('css'),
                                                $this->request->getPost('js'));
                $this->renderVoltText($contentTypeName."_en", $template_en);

                $this->flash->success("Content Type was updated successfully");

                Tag::resetInput();
            }
        }
        $this->tag->setTitle("Content Type : ".$npfContentTypes->human_name);
        $this->view->contentTypes = Contents::get_sys_fld_type_names();
        $this->view->cntntTypes = NpfContentTypes::find();
        $this->view->lookuptbls = NpfLookupTypes::find();
        $this->view->flds = unserialize($npfContentTypes->flds);
        $this->view->sql_query = unserialize($npfContentTypes->sql_query);

        $this->view->sys_fld_types = Contents::get_sys_fld_types();

        $this->view->list_fields = explode(',',$npfContentTypes->list_fields);

        $this->view->form = new ContentTypeForm($npfContentTypes, array('edit' => true));
    }

    private function getTemplateData($v,$c,$j){
        $t = $v;
        $t .= '<style>'.$c.'</style>';
        $t .= '<script>'.$j.'</script>';
        return $t;
    }
    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

//        $user = NpfContentTypes::findFirstById($id);
//        if (!$user) {
//            $this->flash->error("ContentType was not found");
//            return $this->dispatcher->forward(array('action' => 'index'));
//        }
//
//        if (!$user->delete()) {
//            $this->flash->error($user->getMessages());
//        } else {
//            $this->flash->success("ContentType was deleted");
//        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }

    public function typeaheadAction(){
        if ($this->request->isAjax() == true) {
            $this->view->disable();
            $query = $this->request->get('query', 'string', '');
            $npfContentTypes = NpfContentTypes::find(array("conditions" => "name LIKE '".$query."%'","limit" => 5));
            $a_result = array();
            foreach($npfContentTypes as $tmp){

                $a_result[] = $tmp->name;
            }
            //Create a response instance
            $response = new Response();

            //Set the content of the response
            $response->setContentType('application/json', 'UTF-8');
            $response->setContent(json_encode(array("options"=>$a_result)));

            //Return the response
            return $response;
        }
    }
    private function renderVoltText($contentType, $volt_text){
        //Create a compiler
        $compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();
        //Optionally add some options
        $compiler->setOptions(array());

        //Compile a template string returning PHP code
        $tt = $compiler->compileString($volt_text);

        $file = fopen($this->config->application->templateUri.''.$contentType.".compiled","w");
        fwrite($file, $tt);
        fclose($file);
    }

    private function getDefaultSql($contentTypeName,$sql_query, $flds){
        if(trim($sql_query[0])==""){
            $tmp = array();
            $tmp[0] = Contents::gen_default_sql_stmnt($contentTypeName,$flds);
            return $tmp;
        }
        return $sql_query;
    }
}

