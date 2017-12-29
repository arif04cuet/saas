<?php
namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Url,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\View;
use Vokuro\Forms\ContentTypeForm;
use Vokuro\Models\Contents;
use Vokuro\Models\NpfLookups;
use Vokuro\Models\NpfDomains;
use Vokuro\Models\NpfLookupTypes;
use Vokuro\Models\NpfContentTypes;
use Vokuro\Models\NpfDomainResources;
use Vokuro\Models\NpfContentLatestNews;

/**
 * @property mixed uid
 */
class ContentController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }


    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $contentType = $this->dispatcher->getParam('contentType');
        $this->tag->setTitle(ucfirst($contentType));
        $limit = 50;
        $numberPage = 1;
        if ($this->request->isPost()) {
        } else {
            $numberPage = $this->request->getQuery("page", "int");
            $numberPage = $numberPage ? $numberPage : 1;
        }

        $cntType = NpfContentTypes::findFirst('name="' . $contentType . '"');

        $fldLst = $cntType->list_fields;
        $fldLst = empty($fldLst) ? ',' : (',' . $fldLst . ',');

        $domain_id = $this->getDomainId();

        $npfContentCnt = Contents::getContentListPageCount($contentType, $domain_id);
        $npfContents = Contents::getContentListPage($contentType, $domain_id, $limit, $numberPage, $fldLst);


        $total_items = isset($npfContentCnt[0]) ? $npfContentCnt[0]->cnt * 1 : 0;
        $total_pages = ceil($total_items / $limit);


        $tmp = array();

        if (count($npfContents) == 0) {
            if ($this->request->isAjax() == false) {
                $this->flash->notice("The search did not find any Content for Content Type: " . $cntType->name);
                $this->view->page = false;
            }
            //return $this->dispatcher->forward(array("action" => "empty"));
        } else {
            $tmp = array(
                "next" => ($numberPage + 1) < $total_pages ? $numberPage + 1 : $total_pages,
                "first" => 1,
                "before" => ($numberPage - 1) > 0 ? $numberPage - 1 : 1,
                "current" => $numberPage * 1,
                "last" => $total_pages,
                "total_pages" => $total_pages,
                "total_items" => $total_items,
                "data" => $npfContents
            );


            //var_dump($this->view->page);
        }
        if ($this->request->isAjax() == true) {
            $y = array();
            foreach ($npfContents as $t) {
                //var_dump($t);
                $y[] = $t;
            }
            unset($tmp['data']);
            $a_result['page'] = $tmp;
            $a_result['data'] = $y;
            $a_result['contentType'] = $contentType;
            $this->view->disable();
            $response = new Response();
            $response->setContentType('application/json', 'UTF-8');
            $response->setContent(json_encode(array("result" => $a_result)));
            return $response;
        } else {
            $flds = array();
            if ($cntType->list_fields) {
                $flds = explode(',', $cntType->list_fields);
            }

            $this->view->fldLst = $flds;
            $this->view->fldNames = $this->getFieldNames($flds, unserialize($cntType->flds));
            $this->view->page = $tmp;
            $this->view->contentType = $contentType;

            // updated for datatables
            // $this->view->domainId = $this->getDomainId();
            // $customTemplte = 'content/types/' . $contentType . '.volt';
            // if (file_exists($this->config->application->viewsDir . $customTemplte) and 0) {
            //     $this->view->pick(["content/types/$contentType"]);
            // } else
            //     $this->view->pick("content/common");

        }
    }

    public function listajaxAction()
    {
        $contentType = $this->dispatcher->getParam('contentType');
        $limit = 300;
        $numberPage = 1;
        if ($this->request->isPost()) {
        } else {
            $numberPage = $this->request->getQuery("page", "int");
            $numberPage = $numberPage ? $numberPage : 1;
        }

        $cntType = NpfContentTypes::findFirst('name="' . $contentType . '"');
//        $this->flash->notice("Invalid Content Type: $contentType");
//        $this->view->page = false;

        $fldLst = $cntType->list_fields;
        $fldLst = empty($fldLst) ? ',' : (',' . $fldLst . ',');

        $domain_id = $this->getDomainId();
        $npfContentCnt = Contents::getContentListPageCount($contentType, $domain_id);
        $npfContents = Contents::getContentListPage($contentType, $domain_id, $limit, $numberPage, $fldLst);
        $total_items = $npfContentCnt[0]->cnt * 1;
        $total_pages = ceil($total_items / $limit);

        $tmp = array();

        if (count($npfContents) == 0) {
            if ($this->request->isAjax() == false) {
                $this->flash->notice("The search did not find any Content for Content Type: " . $cntType->name);
                $this->view->page = false;
            }
            //return $this->dispatcher->forward(array("action" => "empty"));
        } else {
            $tmp = array(
                "next" => ($numberPage + 1) < $total_pages ? $numberPage + 1 : $total_pages,
                "first" => 1,
                "before" => ($numberPage - 1) > 0 ? $numberPage - 1 : 1,
                "current" => $numberPage * 1,
                "last" => $total_pages,
                "total_pages" => $total_pages,
                "total_items" => $total_items,
                "data" => $npfContents
            );


            //var_dump($this->view->page);
        }

        $flds = array();
        if ($cntType->list_fields) {
            $flds = explode(',', $cntType->list_fields);
        }

        $this->view->fldLst = $flds;
        $this->view->fldNames = $this->getFieldNames($flds, unserialize($cntType->flds));
        $this->view->page = $tmp;
        $this->view->contentType = $contentType;

        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);

        $this->view->setTemplateBefore('ajax');
    }

    private function getFieldNames($flds, $cnt_flds)
    {
        $fldNames = array();
        foreach ($flds as $f) {
            foreach ($cnt_flds as $t) {
                if ($t['name'] . '_bn' == $f) {
                    $fldNames[] = $t['hname'];
                }
            }
            if ($f == 'title_bn') {
                $fldNames[] = 'Title';
            }
        }
//        var_dump($cnt_flds);
        return $fldNames;
    }

    public function versionsAction()
    {
        $id = $this->dispatcher->getParam('id');
        $contentType = $this->dispatcher->getParam('contentType');
        $limit = 10;
        $numberPage = 1;
        if ($this->request->isPost()) {
        } else {
            $numberPage = $this->request->getQuery("page", "int");
            $numberPage = $numberPage ? $numberPage : 1;
        }

//        $domain_id = $this->getDomainId();
        $npfContentCnt = Contents::getContentVersionPageCount($contentType . '_version', $id);
        $npfContents = Contents::getContentVersionPage($contentType . '_version', $id, $limit, $numberPage);
        $total_items = $npfContentCnt[0]->cnt * 1;
        $total_pages = ceil($total_items / $limit);

        if (count($npfContents) == 0) {
            $this->flash->notice("The search did not find any Content for Content Type: $contentType");
            $this->view->page = false;
            //return $this->dispatcher->forward(array("action" => "empty"));
        } else {
            $tmp = array(
                "next" => ($numberPage + 1) < $total_pages ? $numberPage + 1 : $total_pages,
                "first" => 1,
                "before" => ($numberPage - 1) > 0 ? $numberPage - 1 : 1,
                "current" => $numberPage * 1,
                "last" => $total_pages,
                "total_pages" => $total_pages,
                "total_items" => $total_items,
                "data" => $npfContents
            );

            $this->view->page = $tmp;
            //var_dump($this->view->page);
        }

        $this->view->contentType = $contentType;
    }

    public function createAction()
    {

        $contentType = $this->dispatcher->getParam('contentType');
        $t = Contents::getContentTypeProperties($contentType);
        $uuid = '';
        if ($this->request->isPost()) {

            $fldVals = $this->request->getPost();

            $in_latest_news = 0;
            if (isset($fldVals['in_latest_news'])) {
                $in_latest_news = 1;
                unset($fldVals['in_latest_news']);
            }

            unset($fldVals['form_name']);
            unset($fldVals['modal-content-type']);
            unset($fldVals['files']);

            $id = $this->request->getPost('id');

            $fldVals['domain_id'] = $this->getDomainId();
            $fldVals['createdby'] = $this->getUserId();
            $fldVals['lastmodifiedby'] = $this->getUserId();
            $fldVals['publish'] = isset($fldVals['publish']) ? '1' : '0';
            $fldVals['is_right_side_bar'] = isset($fldVals['is_right_side_bar']) ? '1' : '0';

            $fldVals['userip'] = $this->request->getClientAddress();
            $fldVals['useragent'] = $this->request->getUserAgent();
            $fldVals['usergeo'] = '';

            $result = Contents::updateContent(false, $contentType, $t[0]->flds, $fldVals);

            $logMessage = "Created $contentType:" . $this->request->getPost('title_bn');
            $this->log($logMessage);

            if ($result['result']->count() > 0) {
                $this->updateDomainInfo();
                $this->session->set(
                    "content-flash-msg",
                    array("type" => "success", "msg" => $t[0]->human_name . " was created successfully.")
                );

                // Latest news block
                if ($in_latest_news) {
                    $sql = 'select * from npf_content_' . $t[0]->name . ' order by created desc limit 1';
                    $result_set = $this->db->query($sql);
                    $result_set->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                    $result_set = $result_set->fetchAll($result_set);
                    $uuid = $result_set[0]['id'];
                    $latestNews = new NpfContentLatestNews();
                    $latestNews->assign(array(
                        'id' => $uuid,
                        'title_bn' => $fldVals['title_bn'],
                        'title_en' => $fldVals['title_en'],
                        'domain_id' => $this->getDomainId(),
                        'content_type' => $t[0]->name,
                        'version' => 1
                    ));
                    if (!$latestNews->save()) {

                    }
                }


                return $this->response->redirect('content/' . $t[0]->name);
            } else {
                $this->flash->error($result['result']->getMessages());
            }
            $uuid = $fldVals['uploadPath'];
        } else {
            $uuid = $this->uuid->v4();
            $this->view->uuid = $uuid;
            $uuid2 = $this->uuid->v4();
            $this->view->id = $uuid2;
        }

        if (count($t) > 0) {


            $this->view->formName = $t[0]->name;
            $this->view->formHName = $t[0]->human_name;
//            $flds = unserialize($t[0]->flds);
            $flds = Contents::get_active_fields($t[0]->flds);

            $this->view->isTitle = $t[0]->use_title;
            $this->view->isBody = $t[0]->use_body;

            $this->view->lookupData = $this->getLookupValues($flds);
            $this->view->formFields = $flds;
            $this->view->uploadPath = $this->getFileUploadPath($t[0]->name, $uuid);
            $this->view->domain = $this->getDomainName();
            $this->view->latest_news = NpfContentLatestNews::iSLatestNewsCheckBox($t[0]->name, $this->getDomainName());
            $this->view->in_latest_news = 0;
        }
    }

    public function editAction()
    {

        $contentType = $this->dispatcher->getParam('contentType');
        $t = Contents::getContentTypeProperties($contentType);

        $id = $this->dispatcher->getParam('id');
        $nextVersion = $this->getNewVersion($contentType, $id);
        $version = $this->dispatcher->getParam('version');
        $version = $version ? $version : $nextVersion - 1;
        if ($this->request->isPost()) {
            $fldVals = $this->request->getPost();

            unset($fldVals['form_name']);
            unset($fldVals['modal-content-type']);
            unset($fldVals['files']);

            $fldVals['domain_id'] = $this->getDomainId();
            $fldVals['lastmodifiedby'] = $this->getUserId();
            $fldVals['is_right_side_bar'] = isset($fldVals['is_right_side_bar']) ? '1' : '0';
            $fldVals['publish'] = isset($fldVals['publish']) ? '1' : '0';

            $fldVals['userip'] = $this->request->getClientAddress();
            $fldVals['useragent'] = $this->request->getUserAgent();
            $fldVals['usergeo'] = '';

//            Contents::updateContent(true, $contentType, $t[0]->flds, $fldVals);
//            return;
            $result = Contents::updateContent(true, $contentType, $t[0]->flds, $fldVals);

            //loggin
            $logMessage = "Updated $contentType:" . $this->request->getPost('title_bn');
            $this->log($logMessage);

            if ($result['result']->count() > 0) {

//                Contents::setDomainLastContentUpdate($fldVals['domain_id']);
                $this->updateDomainInfo();
                $this->session->set(
                    "content-flash-msg",
                    array("type" => "success", "msg" => $t[0]->human_name . " was updated successfully.")
                );
                return $this->response->redirect('content/' . $t[0]->name);
            } else {
                $this->flash->error($result['result']->getMessages());
            }
            $uuid = $fldVals['uploadPath'];
        }
        $flds = Contents::get_active_fields($t[0]->flds);
        $contentValues = Contents::loadContentValues($contentType, $id, $version, $flds);
        if (count($t) > 0) {
            $this->view->formName = $t[0]->name;
            $this->view->formHName = $t[0]->human_name;

            $this->view->isTitle = $t[0]->use_title;
            $this->view->isBody = $t[0]->use_body;

            $this->view->lookupData = $this->getLookupValues($flds, $contentValues);
            $this->view->formFields = $flds;
            $this->prepareValues($flds, $contentValues);
            $this->view->contentValues = $contentValues;
            $this->view->uploadPath = $this->getFileUploadPath($t[0]->name, $contentValues['uploadpath']);
            $this->view->domain = $this->getDomainName();

            $this->view->version = $nextVersion; //intval($this->view->contentValues['version']) + 1;
        }
    }

    public function editversionAction()
    {
        $contentType = $this->dispatcher->getParam('contentType');
        $t = Contents::getContentTypeProperties($contentType);

        $id = $this->dispatcher->getParam('id');
        $nextVersion = $this->getNewVersion($contentType, $id);
        $version = $this->dispatcher->getParam('version');
        //$version = $version?$version:$nextVersion-1;
//        echo $version;
        if ($this->request->isPost()) {
            $fldVals = $this->request->getPost();

            unset($fldVals['form_name']);
            unset($fldVals['modal-content-type']);
            unset($fldVals['files']);

            $fldVals['domain_id'] = $this->getDomainId();
            $fldVals['lastmodifiedby'] = $this->getUserId();
            $fldVals['publish'] = isset($fldVals['publish']) ? '1' : '0';

            $fldVals['userip'] = $this->request->getClientAddress();
            $fldVals['useragent'] = $this->request->getUserAgent();
            $fldVals['usergeo'] = '';

//            Contents::updateContent(true, $contentType, $t[0]->flds, $fldVals);
//            return;
            $result = Contents::updateContent(true, $contentType, $t[0]->flds, $fldVals);

            if ($result['result']->count() > 0) {

//                Contents::setDomainLastContentUpdate($fldVals['domain_id']);
                $this->updateDomainInfo();
                $this->session->set(
                    "content-flash-msg",
                    array("type" => "success", "msg" => $t[0]->human_name . " was updated successfully.")
                );
                return $this->response->redirect('content/' . $t[0]->name);
            } else {
                $this->flash->error($result['result']->getMessages());
            }
            $uuid = $fldVals['uploadPath'];
        }
        $flds = Contents::get_active_fields($t[0]->flds);
        $contentValues = Contents::loadContentValues($contentType . '_version', $id, $version, $flds);
        if (count($t) > 0) {
            $this->view->formName = $t[0]->name;
            $this->view->formHName = $t[0]->human_name;

            $this->view->isTitle = $t[0]->use_title;
            $this->view->isBody = $t[0]->use_body;

            $this->view->lookupData = $this->getLookupValues($flds, $contentValues);
            $this->view->formFields = $flds;
            $this->prepareValues($flds, $contentValues);
            $this->view->contentValues = $contentValues;
            $this->view->uploadPath = $this->getFileUploadPath($t[0]->name, $contentValues['uploadpath']);
            $this->view->domain = $this->getDomainName();

            $this->view->version = $nextVersion; //intval($this->view->contentValues['version']) + 1;
        }
//        $this->view->pick("content/edit");
    }

    public function deleteAction()
    {
        $contentType = $this->dispatcher->getParam('contentType');
        $t = Contents::getContentTypeProperties($contentType);
        if (count($t) > 0) {
            $id = $this->dispatcher->getParam('id');
            if (Contents::deleteById($contentType, $id)) {
                $this->session->set(
                    "content-flash-msg",
                    array("type" => "success", "msg" => $contentType . " was delete successfully.")
                );
                return $this->response->redirect('content/' . $contentType);
            } else {
                $this->session->set(
                    "content-flash-msg",
                    array("type" => "error", "msg" => $contentType . " was fail to delete.")
                );
                return $this->response->redirect('content/' . $contentType);
            }
        }
    }

    private function updateDomainInfo()
    {
        $domainid = $this->getDomainId();
        $npfDomain = NpfDomains::findFirstById($domainid);
        $date = new \DateTime();

        $npfDomain->assign(array(
            'last_content_updated' => $date->format("Y-m-d H:i:s")
        ));
        if (!$npfDomain->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function prepareValues($flds, &$contentValues)
    {
        foreach ($flds as $fld) {
            if ($fld['type'] == 'domainselector') {
                $did = $contentValues['' . $fld['name']];
                // find the domain info get the name and assign the name
                $domain = NpfDomains::findFirst("id = '" . $did . "'");
                $contentValues['' . $fld['name']] = null;
                if ($domain) {
                    $contentValues['' . $fld['name']] = array('id' => $did, 'name' => $domain->sitename_bn);
                }
                //var_dump($contentValues[''.$fld['name']]['id']);
                //var_dump($contentValues[''.$fld['name']]['name']);
            }
        }
    }

    private function getLookupValues($flds, $fldVals = null)
    {
        $lookups = array();
        foreach ($flds as $fld) {
            if ( ( ($fld['type'] == 'lookuptbl') || ($fld['type'] == 'multiselect'))
                && ($fld['active'] == '1') && ($fld['name'] != '')) {
                if ($fld['dependson'] == '') {
                    //find if the lookup is common if not than add domainid
                    $lookup = NpfLookupTypes::findFirst("id = " . $fld['lookup']);
                    if ($lookup->is_common) {
                        $lookups['' . $fld['name']] = NpfLookups::find("lookuptype_id = " . $fld['lookup']);
                    } else {
                        $domainid = $this->getDomainId();
                        $lookups['' . $fld['name']] = NpfLookups::find("domain_id=" . $domainid . " AND lookuptype_id = " . $fld['lookup']);
                    }

                } else {
                    if ($fldVals) {
                        $val = $fldVals[$fld['dependson']];
                        $lookups['' . $fld['name']] = NpfLookups::find("parent_id = " . $val);
                    } else {
                        $lookups['' . $fld['name']] = array();
                    }
                }
            } else {
                $lookups['' . $fld['name']] = array();
            }
        }
        return $lookups;
    }

    public function uploadAction()
    {
        // Check if the user has uploaded files
        if ($this->request->hasFiles() == true) {
            $this->view->disable();

            $contentType = $this->dispatcher->getParam('contentType');
            $id = $this->dispatcher->getParam('id');

            // Print the real file names and sizes
            foreach ($this->request->getUploadedFiles() as $file) {
                //Print file details
                $file->moveTo($this->imageUploadUri . "content/" . $contentType . "/" . $id . "/" . $file->getName());
                echo $file->getName(), " ", $file->getSize(), "\n";
            }
        }
    }

    private function getNewVersion($contentType, $id)
    {
        $npfContentCnt = Contents::getContentVersionPageCount($contentType . '_version', $id);
        return $npfContentCnt[0]->cnt * 1;
    }
}