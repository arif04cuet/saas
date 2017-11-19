<?php

namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller,
    Phalcon\Mvc\Url,
    Phalcon\Http\Response,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Dispatcher;


use Vokuro\Models\NpfBlocks;
use Vokuro\Models\NpfContentTypes;
use Vokuro\Models\NpfDomains;
use Vokuro\Models\NpfOfficeUsers;
use helperFunctions;
use Vokuro\Models\NpfTemplateBlocks;
use Vokuro\Models\NpfViewContents;

/**
 * ControllerBase
 *
 * This is the base controller for all controllers in the application
 */
class SiteControllerBase extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {

        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->view->setTemplateBefore('frontend');
        $this->view->domain_info = $domain_info = (array)$this->getDomain();
        $this->view->lang = $lang = 'bn';
        $this->view->is_disable_rightbar = false;

        $this->view->banner = $this->buildRegion($domain_info['id'], $lang, 'header');
        $this->view->menu = helperFunctions\buildMenuTree($domain_info['id'], $lang);
        $this->view->rightbar = $this->buildRegion($domain_info['id'], $lang, 'right');

        $this->view->footer = $this->buildFooterMenu($domain_info['id'], $lang);

    }

    public function renderContent($content_type, $content_id)
    {

        $lang = $this->view->lang;
        $domain_info = (array)$this->getDomain();
        $domainid = $domain_info['id'];


        //$sql = "SELECT flds, sql_query, is_right_side_bar FROM {npfministryadmin.npf_content_types} WHERE name = '{$content_type}' "; //-- AND domain_id = $domainid AND active = 1
        $row = NpfContentTypes::findFirstByName($content_type);
        $props['flds'] = $row->flds;
        $props['sql_query'] = $row->sql_query;
        $props['is_right_side_bar'] = $row->is_right_side_bar;

        $flds = unserialize($props['flds']);

        $sql = unserialize($props['sql_query']);
        $sqls = array();
        if (sizeof($sql) <= 0) {
            $sqls[] = "SELECT * FROM {npf_content_$content_type} WHERE id = '$content_id' AND domain_id = $domainid AND active = 1 AND publish = 1";
        } else {

            $params = array(
                'id' => $content_id,
                'domain_id' => $domainid,
                'active' => 1,
                'publish' => 1
            );
            $sysflds = helperFunctions\get_system_fields();

            $flds = helperFunctions\get_fld_merge($sysflds, $flds);
            //var_dump($flds);
            foreach ($sql as $s) {
                $sqls[] = helperFunctions\gen_raw_sql($content_type, $s, $flds, $params, $lang);
            }
        }
        $t = helperFunctions\getResultValuesInVars($sqls, $flds, $lang);
        $t['lang'] = $lang;
        if ($t != false) {

            if (isset($t['content']['is_right_side_bar'])) {
                $this->view->is_disable_rightbar = $t['content']['is_right_side_bar'];
            }

            $compiledFilename = $this->config->application->cacheDir . "files/templates/" . $content_type . "_" . $lang . ".compiled";
            $output = $this->renderPhpFile($compiledFilename, $t);
            $uri = helperFunctions\generateContentEditUri($domain_info, $content_type, $content_id);
            /////////////////Edited by hafij//////////////////////
            //$output= $uri.$output;
            $output = $uri . "<div id='printable_area'>" . $output . "</div>";
            /////////////////Edited by hafij//////////////////////
            $lastupdated = helperFunctions\getlastupdate($content_type, $content_id, $domainid, $lang);
            return $lastupdated . $output;
        }
        return "";
    }

    public function get_view_content($view_name)
    {


        $lang = $this->view->lang;
        $domain_info = (array)$this->getDomain();
        $domainid = $domain_info['id'];

        $args = get_args($this->request->get('q')); // 0 site, 1 view, 2 view_name, 3 arg0, 4 arg1, 5 arg2 ... N argN-3


        $page = $this->request->get('page') ? $this->request->get('page') : '1';
        $rows = $this->request->get('rows') ? $this->request->get('rows') : '20';
        $rows = $rows <= 99999 ? $rows : 99999;

        $offset = ($page - 1) * $rows;

        $t = $this->request->get('t') ? $this->request->get('t') : '';


        $row = NpfViewContents::findFirst(
            array(
                'conditions' => 'name=?1',
                'bind' => array(1 => $view_name),
                'columns' => "header_{$lang} header,footer_{$lang} footer, sql_query,is_right_side_bar,is_pagination",
            )
        );
        $a_result = array();
        $params = array(
            'lang' => $lang,
            'domainid' => $domainid,
            'offset' => $offset,
            'rows' => $rows,
            't' => $t,
            'q' => $args,
        );
        $isPagination = false;
        $t = array();


        $a_result = get_object_vars($row);
        $a_result['sql_query'] = str_replace('npfministryadmin.', '', $a_result['sql_query']);
        $sql = $this->get_view_sql_query($a_result['sql_query'], $params);


        $t['header'] = $a_result['header'];
        $t['footer'] = $a_result['footer'];
        $is_right_side_bar = $a_result['is_right_side_bar'];
        $isPagination = $a_result['is_pagination'];
        $this->view->is_disable_rightbar = $is_right_side_bar;

        $t['contents'] = array();
        $t['paginate'] = array();
        $t['offset'] = $offset;
        $t['rows'] = $rows;


        $result = $this->resultBySql($sql);

        foreach ($result as $row) {
            $this->unserializedRows($row);
            $t['contents'][] = get_object_vars($row);
        }
        if ($isPagination) {
            $t['paginate'] = '';//get_pagination_props($sql, $page, $rows);
        }


        $t['lang'] = $lang;
        $t['q'] = $params['q'];
        $t['t'] = $params['t'];
        $rendered_content = '';

        global $print_btn;
        //var_dump($print_btn);
        if ($print_btn) {
            $rendered_content .= '<div style="float:right;" id="print_btn_div"><img src="/img/print_btn.png" style="cursor: pointer;" onclick="print_content();" width="24" title="প্রিন্ট" /></div><div id="printable_area">';
        }


        $compiledFilename = $this->config->application->cacheDir . "files/templates/views/" . $view_name . "/" . $view_name . "_template_" . $lang . ".compiled";
        $rendered_content = $this->renderPhpFile($compiledFilename, $t);

        if ($print_btn) {
            $rendered_content .= '</div>';
        }

        if ($isPagination and 0) {
            $paginated_content = '<div id="div-view-pagination-' . $view_name . '">';
            $paginated_content .= $rendered_content;
            $paginated_content .= '</div>';
            return $paginated_content;
        } else {
            return $rendered_content;
        }
    }

    public function getDomain()
    {
        $name = $_SERVER['HTTP_HOST'];
        return NpfDomains::findFirstBySubdomain($name);
    }

    public function buildFooterMenu($domainid, $lang)
    {

        $sql = "
			SELECT
			   `link`
			FROM npf_content_footer_menu
			WHERE domain_id = " . $domainid . " AND active = 1 AND publish = 1 order by weight desc
		";

        $result = $this->resultBySql($sql);

        $footer_menu = "<ul>";
        foreach ($result as $row) {
            //var_dump($row->link);
            $footer_menu .= '<li>';
            $footer_menu .= renderLink($row->link, $lang);
            $footer_menu .= '</li>';
        }

        $footer_menu .= '</ul>';
        return $footer_menu;
    }

    public function buildRegion($domainid, $lang, $region)
    {
        $regionid = $this->getRegionId($region);
        $html = $this->get_all_block_by_region($regionid);
        return $html;
    }

    public function getRegionId($region)
    {
        switch ($region) {
            case 'left':
                return 1;
            case 'footer':
                return 2;
            case 'right':
                return 3;
            case 'header':
                return 4;
            case 'header_top':
                return 5;
        }
        return 0;
    }

    public function get_all_block_by_region($regionid)
    {
        $lang = $this->view->lang;
        $domain_info = (array)$this->getDomain();

        $domainid = $domain_info['id'];

        $blocks = NpfBlocks::find(
            array(
                'conditions' => 'domain_id=?1 and region_id=?2',
                'bind' => array(1 => $domainid, 2 => $regionid),
                'columns' => "title_{$lang} title, body_{$lang} body,template_block_name,more",
                'order' => 'weight'

            )
        );
        $html = '';
        foreach ($blocks as $row) {
            $html .= $this->get_block_view($row->template_block_name, $row->title, $row->body, $row->more);
        }

        return $html;
    }

    public function get_block_view($block_name, $title, $body, $more)
    {
        $lang = $this->view->lang;
        $domain_info = (array)$this->getDomain();
        $domainid = $domain_info['id'];


        $tBlock = NpfTemplateBlocks::findFirstByName($block_name);
        $params = array(
            'lang' => $lang,
            'domainid' => $domainid,
        );


        $t = array();
        $a_result = get_object_vars($tBlock);
        $a_result['sql'] = str_replace('npfministryadmin.', '', $a_result['sql']);
        $sql = $this->get_view_sql_query($a_result['sql'], $params);

        if (empty($sql))
            return;

        $t['contents'] = array();

        $result = $this->resultBySql($sql);

        foreach ($result as $row) {
            unserializedRows($row);
            $t['contents'][] = get_object_vars($row);
        }


        $t['lang'] = $lang;
        $t['title'] = $title;
        $t['body'] = $body;
        $t['more'] = $more;

        $compiledFilename = $this->config->application->cacheDir . "files/templates/blocks/" . $block_name . "/" . $block_name . "_template_" . $lang . ".compiled";
        return $this->renderPhpFile($compiledFilename, $t);
    }

    public function  unserializedRows(&$row)
    {

        foreach ($row as &$col) {
            if ($this->is_serialized($col)) {
                $col = unserialize($col);
            }
        }
    }

    public function is_serialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (!is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (!preg_match('/^([adObis]):/', $data, $badions))
            return false;
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                    return true;
                break;
        }
        return false;
    }

    public function get_view_sql_query($sql, $params)
    {

        if (isset($params['t'])) {
            if (is_array($params['t'])) {
                foreach ($params['t'] as $tag => $replace) {
                    $sql = str_replace('{$t_' . $tag . '}', $replace, $sql);
                }
                unset($params['t']);
            }
        }
        if (isset($params['q']) && is_array($params['q'])) {
            foreach ($params['q'] as $tag => $replace) {
                $sql = str_replace('{$q_' . $tag . '}', $replace, $sql);
            }
            unset($params['q']);
        }
        foreach ($params as $tag => $replace) {
            $sql = str_replace('{$' . $tag . '}', $replace, $sql);

        }
        //echo $sql;
        return $sql;
    }

    public function renderPhpFile($filename, $vars = null)
    {
        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }
        ob_start();
        include $filename;
        return ob_get_clean();
    }


    public function resultBySql($sql)
    {

        $result_set = $this->db->query($sql);
        $result_set->setFetchMode(\Phalcon\Db::FETCH_OBJ);
        return $result_set->fetchAll($result_set);
    }

}