<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class ApiController extends ControllerBase
{
    public function initialize()
    {
    }

    public function CreateContentTypeAction()
    {
        //error_reporting(E_ALL);

        $result = ['status' => 'error', 'data' => 'Request Must be POST'];
        if ($this->request->isPost()) {

            $result = [];
            $request_data = $this->request->getPost();

            if (empty($request_data)) {
                $result = ['status' => 'error', 'msg' => "Missing Post Data"];
            }
            $inner_function = function () use ($request_data) {
                $API_KEY_FOR_NOTHI = 'aPmnN3n8Qb';
                if (empty($request_data["api_key"]) || $request_data["api_key"] != $API_KEY_FOR_NOTHI) {
                    return ['status' => 'error', 'msg' => "Missing Api Key"];
                }

                $domainName = $_SERVER['HTTP_HOST'];
                $domainParts = explode('.', $domainName);
                $domainName = $domainParts[0] . ".portal.gov.bd";
                $domain = \Vokuro\Models\NpfDomains::findFirst(
                    [
                        'conditions' => "subdomain LIKE '%" . $domainName . "%'",
                    ]
                );
                $domainId = $domain->id;

                if (!isset($domain->id)) {

                    return ['status' => 'error', 'msg' => "requested domain not found"];
                }

                if (empty($request_data["title_bn"]) || empty($request_data['title_en'])) {
                    return ['status' => 'error', 'msg' => "Missing Content Title"];
                }

                switch ($request_data['content_type']) {
                    case 'notices':
                        if (empty($request_data["pubdate"]) || empty($request_data['archive_date'])) {
                            return ['status' => 'error', 'msg' => "Missing Publish/Archive Date"];
                        }
                        break;
                }

            };

            $result = $inner_function();
            if (empty($result)) {


                try {
                    $domainName = $_SERVER['HTTP_HOST'];
                    $domainParts = explode('.', $domainName);
                    $domainName = $domainParts[0] . ".portal.gov.bd";
                    $domain = \Vokuro\Models\NpfDomains::findFirst(
                        [
                            'conditions' => "subdomain LIKE '%" . $domainName . "%'",
                        ]
                    );

                    $domainId = $domain->id;
                    $title_bn = $this->request->getPost('title_bn');
                    $title_en = $this->request->getPost('title_en');
                    $body_bn = $this->request->getPost('body_bn');
                    $body_en = $this->request->getPost('body_en');

                    $contentType = $this->request->getPost('content_type');
                    $attachments = $this->request->getPost('attachments');
                    $publish_date = $this->request->getPost('pubdate');
                    $archive_date = $this->request->getPost('archive_date');
                    $is_guard_file = $this->request->getPost('is_guard_file');
                    $pdfs = array();

                    $uuid = $this->uuid->v4();
                    $current_domain_id = $domainId;
                    $publish_domains[] = $current_domain_id;
                    $t = \Vokuro\Models\Contents::getContentTypeProperties($contentType);


                    if (!empty($request_data['attachments'])) {

                        $nothiFileUrls = $request_data['attachments'];
                        $nothiFileUrl = $nothiFileUrls[0];
                        //foreach ($nothiFileUrls as $nothiFileUrl) {
                        // $nothiFileUrl = explode('.', $nothiFileUrl);
                        // $newFileName = uniqid() . '.' . end($nothiFileUrl);
                        // $npfUploadPath = 'sites/default/files/files/' . $domain->subdomain . '/' . $contentType . '/' . str_replace("-", "_", $uuid);
                        // $newUploadPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $npfUploadPath;
                        // $newFilePath = $newUploadPath . '/' . $newFileName;
                        // if (!is_dir($newUploadPath)) {
                        //     mkdir($newUploadPath);
                        // }
                        //file_put_contents($newFilePath, file_get_contents($nothiFileUrl));
                        $pdfs[] = array(
                            'name' => $title_bn,
                            'path' => '',
                            'caption_bn' => $title_bn,
                            'caption_en' => $title_en,
                            'link' => $nothiFileUrl
                        );
                        //}
                    }

                    if ($contentType == 'notices') {
                        $fldVals['pubdate'] = $publish_date;
                        $fldVals['archivedate'] = $archive_date;
                        $fldVals['attachments'] = $pdfs;
                    } elseif ($contentType == 'news') {
                        $fldVals['pubdate'] = $publish_date;
                        $fldVals['archivedate'] = $archive_date;
                    } elseif ($contentType == 'notification_circular') {
                        $fldVals['pdf'] = $pdfs;
                        $fldVals['doc'] = array();
                        $fldVals['publish_date'] = $publish_date;
                    }
                    //common fields

                    $fldVals['title_bn'] = $title_bn;
                    $fldVals['title_en'] = $title_en;
                    $fldVals['body_bn'] = $body_bn;
                    $fldVals['body_en'] = $body_en;

                    $fldVals['uploadpath'] = $uuid;
                    $fldVals['id'] = $uuid;
                    $fldVals['createdby'] = 0;
                    $fldVals['publish'] = 1;
                    $fldVals['version'] = 0;
                    $fldVals['lastmodifiedby'] = 0;
                    $fldVals['publish'] = 1;
                    $fldVals['is_right_side_bar'] = 0;
                    $fldVals['userip'] = $this->request->getClientAddress();
                    $fldVals['useragent'] = $this->request->getUserAgent();
                    $fldVals['usergeo'] = '';
                    $fldVals['domain_id'] = $domainId;


                    $result = \Vokuro\Models\Contents::updateContent(false, $contentType, $t[0]->flds, $fldVals, $t[0]->use_body);

                    //save Guard files
                    /* if ($is_guard_file) {
                         $fldVals['pdf'] = $pdfs;
                         $fldVals['doc'] = array();
                         $fldVals['publish_date'] = $publish_date;
                         $contentType = 'notification_circular';
                         $t = \Vokuro\Models\Contents::getContentTypeProperties($contentType);
                         $result = \Vokuro\Models\Contents::updateContent(false, $contentType, $t[0]->flds, $fldVals, $t[0]->use_body);
                     }*/

                    if ($result['result']->count() > 0) {
                        $response = array(
                            'unique_id' => $request_data['unique_id'],
                            'id' => $uuid
                        );
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode($response, JSON_UNESCAPED_UNICODE);
                        exit;
                    } else {
                        $result['status'] = 'error';
                        $result['msg'] = $result['result']->getMessages();
                    }

                } catch (\Exception $e) {
                    $result['status'] = 'error';
                    $result['msg'] = $e->getMessage();
                }
            }
            echo json_encode($result);
            exit;
        }

    }

    public function guardFilesAction()
    {

        $API_KEY_FOR_NOTHI = 'aPmnN3n8Qb';
        if (!isset($_GET['api_key']) || $_GET['api_key'] != $API_KEY_FOR_NOTHI) {
            return json_encode(['status' => 'error', 'msg' => "Missing Api Key"]);
            exit;
        }

        $connection = $this->db;
        if (isset($_GET['category'])) {
            $lang = isset($_GET['lang']) ? $_GET['lang'] : 'bn';
            $sql = "SELECT d.id,d.sitename_{$lang} as name,count(c.id) as total FROM `npf_domains` as d join npf_content_notification_circular as c on (c.domain_id=d.id) where d.active=1 group by d.sitename_bn order by -d.weight desc";
            $contents = $connection->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC);
            $response['status'] = 'SUCCESS';
            $response['data'] = $contents;

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit;

        } elseif (isset($_GET['ministry']) and $_GET['name']) {

            $data = '';
            $lang = isset($_GET['lang']) ? $_GET['lang'] : 'bn';
            $name = $_GET['name'];
            //$sql = "SELECT d.sitename_{$lang} as name,d.subdomain,c.id,c.title_{$lang} as title,c.uploadpath,c.pdf FROM `npf_content_notification_circular` as c join npf_domains as d on(d.id=c.domain_id) where d.sitename_bn='" . $name . "' order by c.lastmodified";
            $sql = "SELECT d.sitename_{$lang} as type,d.subdomain,c.id,c.title_{$lang} as name,c.uploadpath,c.pdf,c.created FROM `npf_content_notification_circular` as c join npf_domains as d on(d.id=c.domain_id)";

            if ($_GET['name'] != 'all') {
                //$sql .= "where d.sitename_{$lang}='" . $name . "'";
                $sql .= "where d.alias like '%" . $name . "%'";
            }
            $sql .= 'order by FIELD(d.subdomain, "cabinet.portal.gov.bd") DESC';


            $contents = $connection->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC);

            foreach ($contents as $item) {

                $item['pdf'] = unserialize($item['pdf']);
                $fileName = isset($item['pdf'][0]['name']) ? $item['pdf'][0]['name'] : '';
                $domain = str_replace('.portal', '', $item['subdomain']);
                $downloadUrl = 'http://' . $domain . '/sites/default/files/files/' . $item['subdomain'] . '/notification_circular/' . str_replace('-', '_', $item['uploadpath']) . '/' . $fileName;

                $allowed_ext = array('pdf', 'doc', 'jpg', 'docx', 'png');
                $fileExt = explode('.', $fileName);
                $fileExt = strtolower(end($fileExt));
                if (!in_array($fileExt, $allowed_ext))
                    continue;

                $data[] = array(
                    'type' => $item['type'],
                    'subdomain' => $item['subdomain'],
                    'name' => $item['name'],
                    'link' => $downloadUrl
                );

            }

            /* $result_set = array_filter($result_set, function ($item) {
                 $allowed_ext = array('pdf', 'doc', 'jpg', 'docx', 'png');
                 $fileExt = strtolower(end(explode('.', $item['link'])));
                 return in_array($fileExt, $allowed_ext) and !empty($item['link']);
             });*/

            $response['status'] = 'SUCCESS';
            $response['data'] = $data;

            //$data = json_encode($result_set, JSON_UNESCAPED_UNICODE);
            //$fileName = './guard_files_' . $lang . '.txt';
            //file_put_contents($fileName,$data);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }
    }
}