<?php

namespace Vokuro\Controllers;

class AboutController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }

    public function renderAction()
    {
        $filename = $this->config->application->actionUri . '/test.php';
        $vars = array();
        $vars['this'] = $this;
        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }
        ob_start();
        include $filename;
        $output = ob_get_clean();
        echo $output;
    }

    public function crawlAction()
    {

        $contentType = array(
            'notices',
            'page',
            'news',
            'policies',
            'publications',
            'annual_reports',
            'biography',
            'tenders',
            'allnotes'
        );
        foreach ($contentType as $table) {

            $tableName = 'npf_content_' . $table;
            $category = $table;
            $sql = "select mt.id, mt.title_en title_en, mt.title_bn title_bn, mt.body_en body_en, mt.body_bn body_bn, '" . $category . "' as category, mt.domain_id domain_id,dt.subdomain subdomain,dt.alias alias, dt.sitename_en sitename_en, dt.sitename_bn sitename_bn from $tableName as mt join npf_domains as dt on (mt.domain_id=dt.id) where mt.active=1 and mt.publish =1 and mt.lastmodified >= '2015-11-30'";
            $result_set = $this->db->query($sql);
            $result_set->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
            $result_set = $result_set->fetchAll($result_set);
            $values = '';
            foreach ($result_set as $row) {
                $row = array_map('strip_tags', $row);
                $parts = explode(".", $row['subdomain']);
                $domainName = $row['alias'] ? 'www.' . $parts[0] . '.gov.bd' : $row['subdomain'];
                $link = $domainName . '/site/' . $category . '/' . $row['id'];
                $values[] = '("' . $row['id'] . '", "' . $row['title_en'] . '", "' . $row['title_bn'] . '","' . $link . '","' . $row['body_en'] . '","' . $row['body_bn'] . '","' . $category . '","' . $row['domain_id'] . '","' . $domainName . '","' . $row['sitename_en'] . '","' . $row['sitename_bn'] . '")';
            }
            $bulkInsert = 'insert into content_modification_logs (id,title_en,title_bn,link,desc_en,desc_bn,category,domain_id,domain_name,sitename_en,sitename_bn) VALUES ' . implode(',', $values);
            $this->db->query($bulkInsert);
        }
    }

    public function exportAction()
    {

        $sql = <<<EOL
 (SELECT "id","title_bn","title_en","link","desc_bn","desc_en","category","domain_id","domain_name","sitename_bn","sitename_en","lastmodified") union all(SELECT id,title_bn,title_en,link,replace(desc_bn,'\n',''),replace(desc_en,'\n',''),category,domain_id,domain_name,sitename_bn,sitename_en,lastmodified INTO OUTFILE "/vagrant/www/saas/npfadmin/app/cache/solr1.csv" FIELDS TERMINATED BY "," ENCLOSED BY '"' FROM content_modification_logs)
EOL;
        $this->db->query($sql);
    }
}

