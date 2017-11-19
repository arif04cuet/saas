<?php
namespace helperFunctions;

use Vokuro\Models\NpfBlocks;
use Vokuro\Models\NpfLookups;


function getlastupdate($content_type, $content_id, $domainid, $lang)
{


    $sql = "SELECT DATE_FORMAT(lastmodified,'%D %M %Y') lastmodified FROM npf_content_$content_type WHERE id = '$content_id' AND domain_id = $domainid AND active = 1 AND publish = 1
	";

    $row = resultBySql($sql);
    $row = $row[0];
    if ($row) {
        $a_result = get_object_vars($row);
        $lastmodified = digit_to_bangla($a_result['lastmodified'], $lang);
        if ($lang == 'bn') {
            return '<div id="print_btn_div"><img src="/img/print_btn.png" style="cursor: pointer;" onclick="print_content();" width="24" title="প্রিন্ট" /></div><div class="updateText" style="float:right;font-style:italic;font-size:.8em;color:#666;">সর্ব-শেষ হাল-নাগাদ: ' . $lastmodified . '</div><hr id="print_div_hr" />';
        } else {
            return '<div id="print_btn_div"><img src="img/print_btn.png" style="cursor: pointer;" onclick="print_content();" width="24" title="print" /></div><div class="updateText" style="float:right;font-style:italic;font-size:.8em;color:#666;">Last updated: ' . $lastmodified . '</div><hr id="print_div_hr" />';
        }
    }
    return '';
}

function generateContentEditUri($domain_info, $content_type, $content_id)
{

    if (!isset($_COOKIE['logged-in'])) {
        return '';
    }
    if ($_COOKIE['logged-in'] != "logged-in") {
        return '';
    }
    $sql = "SELECT version FROM npf_content_$content_type WHERE id = '$content_id' AND domain_id = " . $domain_info['id'] . " AND active = 1 AND publish = 1 ORDER BY version LIMIT 0,1";

    $row = resultBySql($sql);
    $row = $row[0];
    $version = '';
    if ($row) {
        $row = get_object_vars($row);
        $version = $row['version'];
        $uri = $domain_info['subdomain'] . '/npfadmin/content/' . $content_type . '/edit/' . $content_id . '/' . $version;
        $uri = '<a href="http://' . $uri . '" target="_blank" > Edit </a>';
        return $uri . '<hr/>';
    } else {
        return '';
    }
}


function get_lookup_value($lookuptblid, $lookupid, $lang)
{
    //$sql = "SELECT name_$lang AS name FROM npfministryadmin.npf_lookups WHERE lookuptype_id = '$lookuptblid' AND id = '$lookupid' "; //-- AND domain_id = $domainid AND active = 1
    $row = NpfLookups::findFirst(
        array(
            'conditions' => 'lookuptype_id =?1 and id=?2',
            'bind' => array(1 => $lookuptblid, 2 => $lookupid),
            'columns' => "name_$lang name"
        )
    );
    if ($row) {
        return $row->name;
    } else {
        return "";
    }
}


function getUnserializeValues(&$contentValues, $flds, $lang)
{
    foreach ($flds as &$fld) {
        switch ($fld['type']) {
            case "filefield":
            case "nodereference":
            case "imglist":
            case "geocode":
            case "linklist":
            case "contentref":
            case "multicontentref":
            case "multitext":
            case "multihtmltext":
                if (isset($contentValues[$fld['name']])) {
                    $contentValues[$fld['name']] = unserialize($contentValues[$fld['name']]);
                }
                break;
            case "lookuptbl":
                if (isset($contentValues[$fld['name']])) {
                    $contentValues[$fld['name']] = get_lookup_value($fld['lookup'], $contentValues[$fld['name']], $lang);
                }
                break;
            case "multiselect":
                //echo $fld['name'];
                //var_dump($contentValues);
                if (isset($contentValues[$fld['name']])) {
                    //var_dump($contentValues[$fld['name']]);
                    $vals = explode(',', $contentValues[$fld['name']]);
                    $tmp = array();
                    foreach ($vals as &$val) {
                        $tmp[] = array('id' => $val, 'name' => get_lookup_value($fld['lookup'], $val, $lang));
                    }
                    $contentValues[$fld['name']] = $tmp;
                }
                break;
            case "domainselector":
                if (isset($contentValues[$fld['name']])) {
                    $val = get_domain_info($contentValues[$fld['name']], $lang, "id");
                    $tmp = null;
                    if ($val) {
                        $tmp = array('id' => $val['id'], 'subdomain' => $val['subdomain'], 'name' => $val['sitename']);
                    }
                    $contentValues[$fld['name']] = $tmp;
                }
                break;
            //case "date":
            //case "datetime":
            case "number_integer":
            case "number_long":
            case "number_decimal":

                $contentValues[$fld['name']] = digit_to_bangla($contentValues[$fld['name']], $lang);
                break;
        }
    }
}


function getResultValuesInVars($sqls, $flds, $lang)
{

    $t = array();
    foreach ($sqls as $sql) {
        //$sql = str_replace('{{','',$sql);
        //$sql = str_replace('}}','',$sql);
        $row = resultBySql($sql);
        if ($row) {
            $row = get_object_vars($row[0]);
            getUnserializeValues($row, $flds, $lang);

            $t['content'] = $row;

        } else {
            return false;
        }
    }

    return $t;
}

function get_fld_merge($sysflds, $content_flds)
{
    $flds = array();
    foreach ($sysflds as $fld) {
        $flds[] = $fld; //array("name"=>$fld['name'],"type"=>$fld['type']);
    }
    foreach ($content_flds as $fld) {
        $flds[] = $fld; //array("name"=>$fld['name'],"type"=>$fld['type']);
    }
    return $flds;
}


function gen_raw_sql($contentName, $sql, $flds, $params, $lang)
{
    foreach ($flds as $fld) {
        $fld_name = get_org_fld_name($fld, $lang);
        $sql = str_replace("{{" . $fld['name'] . "}}", $fld_name, $sql);
    }
    $sql = get_sysinject_values($contentName, $sql, $params);
    // replace the content_type names last
    $sql = str_replace("{{:", 'npfministryadmin.npf_content_', $sql);
    $sql = str_replace(":}}", '', $sql);
    return $sql;
}


function get_org_fld_name($fld, $lang)
{
    if ($fld['type'] == 'text' || $fld['type'] == 'htmltext') {
        return $fld['name'] . '_' . $lang;
    }
    return $fld['name'];
}

function get_sysinject_values($contentName, $sql, $params)
{
    $sysvars = get_sysinject_vars();
    foreach ($sysvars as $name => $flds) {
        $pos = strpos($sql, '{{' . $name . '}}');

        if ($pos === false) {
        } else {
            $tmp = '1=1 ';
            foreach ($flds as $fld) {
                if (isset($params['' . $fld])) {
                    $tmp .= " AND " . $contentName . "." . $fld . "='" . $params['' . $fld] . "' ";
                }
            }
            $sql = str_replace("{{" . $name . "}}", $tmp, $sql);
        }
    }
    return $sql;
}

function get_sysinject_vars()
{
    $sysvars = array(
        'sysinject' => array('domain_id', 'active', 'publish', 'id'),
        'domain' => array('domain_id'),
        'active' => array('active'),
        'publish' => array('publish'),
        'id' => array('id')
    );
    return $sysvars;
}


function get_system_fields()
{

    $flds = array();
    $flds[] = array('name' => 'id', 'type' => 'id');
    $flds[] = array('name' => 'version', 'type' => 'number_integer');
    $flds[] = array('name' => 'active', 'type' => 'bool');
    $flds[] = array('name' => 'publish', 'type' => 'bool');
    $flds[] = array('name' => 'created', 'type' => 'datetime');
    $flds[] = array('name' => 'lastmodified', 'type' => 'datetime');
    $flds[] = array('name' => 'createdby', 'type' => 'uuid');
    $flds[] = array('name' => 'lastmodifiedby', 'type' => 'uuid');
    $flds[] = array('name' => 'domain_id', 'type' => 'number_integer');
    $flds[] = array('name' => 'office_id', 'type' => 'uuid');
    $flds[] = array('name' => 'menu_id', 'type' => 'uuid');
    $flds[] = array('name' => 'title', 'type' => 'text');
    $flds[] = array('name' => 'body', 'type' => 'htmltext');
    $flds[] = array('name' => 'userpermissionsids', 'type' => 'serialized');
    $flds[] = array('name' => 'uploadpath', 'type' => 'uuid');
    $flds[] = array('name' => 'userip', 'type' => 'varchar');
    $flds[] = array('name' => 'useragent', 'type' => 'varchar');
    $flds[] = array('name' => 'usergeo', 'type' => 'varchar');
    $flds[] = array('name' => 'is_right_side_bar', 'type' => 'bool');
    return $flds;
}


function buildMenuTree($domainid, $lang)
{

    $sql = "
		SELECT
			id,title_" . $lang . " 'title',parent_id,link_path,router_path,external,has_children,depth
		FROM npf_menus
		WHERE   active=1 AND domain_id = " . $domainid . "
		ORDER BY depth, weight
	";

    $result = resultBySql($sql);
    $a_result = array();
    foreach ($result as $row) {
        $a_result[] = get_object_vars($row);
    }

    $tree = get_menu($a_result);
    $tree = buildMenu($tree);
    return $tree;
}

function get_menu($arr)
{
    //echo sizeof($arr);
    if (sizeof($arr) > 0) {
        $new = array();
        foreach ($arr as $a) {
            $new[$a['parent_id']][] = $a;
        }
        $tree = createTree($new, $new[0]); // changed

        //print_r($tree);
        return $tree;
    } else {
        return array();
    }
}

function get_number_text($i)
{
    switch ($i) {
        case 1:
            return "one";
        case 2:
            return "two";
        case 3:
            return "three";
        case 4:
            return "four";
        case 5:
            return "five";
    }
    return "four";
}

function buildMenu($tree)
{
    $menu = "";
    $i = 0;
    $j = 0;
    foreach ($tree as $leaf) {
        if ($leaf['depth'] == 1) {
            //echo $i;
            $cmenu = '';
            $cls = 'col' . $i . ' ';
            if ($leaf['has_children'] == 1) {
                $cls .= "mzr-drop";
                $children = $leaf['children'];
                $chlds = sizeof($children);
                $col_no = 1;

                if ($chlds > 4) {
                    $col_no = 4;
                } else {
                    $col_no = $chlds;
                }
                //echo $col_no;
                if ($i == 6) {
                    if ($col_no > 3) {
                        $col_no = 3;
                    }
                } else if ($i == 7) {
                    if ($col_no > 2) {
                        $col_no = 2;
                    }
                } else if ($i > 7) {
                    if ($col_no > 1) {
                        $col_no = 1;
                    }
                }
                $clss = get_number_text($col_no);
                $ccmenu = '';

                foreach ($children as $child) {

                    if ($child['depth'] == 2) {

                        $ccmenu .= '<div class="one-col">';
                        $ccmenu .= '<h6>' . $child['title'] . '</h6>';
                        $cccmenu = '';
                        if ($child['has_children'] == 1 && isset($child['children'])) {
                            $cchildren = $child['children'];

                            $cccmenu .= '<ul class="mzr-links">';
                            foreach ($cchildren as $cchild) {
                                if ($cchild['external'] == 1) {
                                    if ($cchild['link_path'] == '[front]') {
                                        $cccmenu .= '<li><a href="/">' . $cchild['title'] . '</a></li>';
                                    } else {
                                        $cccmenu .= '<li><a href="' . $cchild['link_path'] . '">' . $cchild['title'] . '</a></li>';
                                    }
                                } else {
                                    if ($cchild['router_path'] == 'nolink') {
                                        $cccmenu .= '<li><a href="javascript:;">' . $cchild['title'] . '</a></li>';
                                    } else {
                                        $cccmenu .= '<li><a href="' . $cchild['link_path'] . '">' . $cchild['title'] . '</a></li>';
                                    }
                                }
                            }
                            $cccmenu .= '</ul>';
                        }
                        $ccmenu .= $cccmenu;
                        $ccmenu .= '</div>';
                    }
                }
                $cmenu .= '<div class="mzr-content drop-' . $clss . '-columns">';
                $cmenu .= $ccmenu;
                $cmenu .= '</div>';
            }
            $menu .= '<li class="' . $cls . '">';
            if ($leaf['external'] == 1) {
                if ($leaf['link_path'] == '[front]') {
                    $menu .= '<a href="/">' . $leaf['title'] . '</a>';
                } else {
                    $menu .= '<a href="' . $leaf['link_path'] . '">' . $leaf['title'] . '</a>';
                }
            } else {
                $menu .= '<a href="#">' . $leaf['title'] . '</a>';
            }
            $menu .= $cmenu;
            $menu .= '</li>';
            $i++;
        }
    }
    return $menu;
}

function createTree(&$list, $parent)
{
    $tree = array();
    foreach ($parent as $k => $l) {
        if (isset($list[$l['id']])) {
            $l['children'] = createTree($list, $list[$l['id']]);
        }
        $tree[] = $l;
    }
    return $tree;
}

function resultBySql($sql)
{

    $sql = str_replace('npfministryadmin.', '', $sql);
    $di = \Phalcon\DI::getDefault();
    $result_set = $di->get('db')->query($sql);
    $result_set->setFetchMode(\Phalcon\Db::FETCH_OBJ);
    return $result_set->fetchAll($result_set);
}


