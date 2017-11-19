<?php
use Vokuro\Models\NpfDomains;

function buildRegion($domainid, $lang, $region)
{
    $regionid = getRegionId($region);
    $html = get_all_block_by_region($regionid);
    return $html;
}


/**
 * Implements hook_menu.
 */
function npfcore_init()
{
    global $domain_info;
    global $print_btn;
    global $language;

    global $is_right_side_bar;

    $print_btn = true;


    $is_right_side_bar = "0";
    // get lang cookie

    /*
    if(isset($_COOKIE['lang'])){
        $lang = $_COOKIE['lang'];
        $languages = language_list();
        if(isset($languages[$lang])){
            $language = $languages[$lang];
        }
    }
    */


    $domain_name = $_SERVER['HTTP_HOST'] == 'localhost' ? 'cabinet.gov.bd' : $_SERVER['HTTP_HOST'];

    //////////////////////////////////
    $domain_info_temp = get_domain_info($domain_name, 'bn', 'subdomain');
    select_lan($domain_info_temp['site_default_language']);
    $lang = $language->language;
    //////////////////////////////////

    $domain_info = get_domain_info($domain_name, $lang, 'subdomain');

    $app_name = '/npfministry';
}

function select_lan($default_lan)
{
    global $language;


    ///////////////////////////////
    /* if (isset($_REQUEST['lang'])) {
         $m_lang = $_REQUEST['lang'];
     } else {
         if (isset($_SESSION['lang'])) {
             $m_lang = $_SESSION['lang'];
         } else {
             $m_lang = $default_lan;
         }

     }*/

    $lang = $_COOKIE['lang'] ? $_COOKIE['lang'] : $default_lan;

    if (isset($_REQUEST['lang']) and $_REQUEST['lang'] != $_COOKIE['lang']) {
        unset($_COOKIE['lang']);
        setcookie("lang", $_REQUEST['lang']);
        $lang = $_REQUEST['lang'];
    }

    $languages = language_list();
    if (isset($languages[$lang])) {
        $language = $languages[$lang];
    }
}


function get_domain_info($domain_fldval, $lang, $domain_fldname = "subdomain")
{
    $sql = "
		SELECT
		  d.`id`,
		  d.`subdomain`,
		  d.`alias`,
		  d.`domain_type_id`,
		  d.`parent_id`,
		  d.`active`,

		  d.`site_mail`,
		  d.`analytics_id`,
		  d.`template`,
		  d.`site_default_language`,
		  d.`site_frontpage`,
		  d.`site_offline`,
		  d.`last_content_updated`,

		  d.`sitename_bn` 'sitename_bn',
		  d.`site_slogan_bn` 'siteslogan_bn',
		  d.`site_footer_bn` 'sitefooter_bn',
		  d.`site_mission_bn` 'sitemission_bn',
		  d.`meta_description` 'meta_description',

		  d.`sitename_en` 'sitename_en',
		  d.`site_slogan_en` 'siteslogan_en',
		  d.`site_footer_en` 'sitefooter_en',
		  d.`site_mission_en` 'sitemission_en',

		  d.`sitename_" . $lang . "` 'sitename',
		  d.`site_slogan_" . $lang . "` 'siteslogan',
		  d.`site_footer_" . $lang . "` 'sitefooter',
		  d.`site_mission_" . $lang . "` 'sitemission',
		  dt.name 'type_name'
			FROM npfministryadmin.npf_domains d
			INNER JOIN npfministryadmin.npf_domain_types dt
			ON d.domain_type_id = dt.id
		WHERE d.`$domain_fldname` = '$domain_fldval'
	";
    if ($domain_fldname == "subdomain") {
        $sql .= " OR FIND_IN_SET('$domain_fldval',d.`alias`)";
    }
    $result = db_query($sql);
    $a_result = array();

    while ($row = db_fetch_object($result)) {
        $a_result = get_object_vars($row);
    }
    return $a_result;
}

/**
 * Implements hook_menu.
 */
function npfcore_menu()
{
    $items = array();
    $items['nolink'] = array(
        'page callback' => 'get_nolink',
        'page arguments' => array(2),
        'access arguments' => array('access content'),
        'type' => MENU_CALLBACK,
    );
    $items['site/view/%'] = array(
        'page callback' => 'get_view_content',
        'page arguments' => array(2),
        'access arguments' => array('access content'),
        'type' => MENU_CALLBACK,
    );
    $items['site/search'] = array(
        'page callback' => 'do_search',
        'page arguments' => array(2),
        'access arguments' => array('access content'),
        'type' => MENU_CALLBACK,
    );
    $items['site/ajaxview/%'] = array(
        'page callback' => 'get_ajax_view_content',
        'page arguments' => array(2),
        'access arguments' => array('access content'),
        'type' => MENU_CALLBACK,
    );
    $items['site/%/%'] = array(
        'page callback' => 'get_contents',
        'page arguments' => array(1, 2),
        'access arguments' => array('access content'),
        'type' => MENU_CALLBACK,
    );
    $items['user'] = array(
        'title' => t('User Admin'),
        'page callback' => 'drupal_goto',
        'page arguments' => array('npfadmin/'),
        'access arguments' => array('access content'),
        'type' => MENU_CALLBACK,
    );


    return $items;
}

function npfcore_preprocess_html(&$vars)
{


}

function do_search()
{
    $domain = $_SERVER['HTTP_HOST'];
    $css = '';
    if ($_GET['q'] == 'site/search') {
        $css = '<style>#right-content{display: none;}#left-content{width: 960px}</style>';
    }
    $q = $_GET['key'];
    $url = 'http://www.pipilika.com/search?q=' . $q . '&infokosh=portal&subcategory=' . $domain;
    $iframe = '<iframe id="pip_iframe" src="' . $url . '" style="border:0px #FFFFFF none;" name="Pipilika Search" scrolling="yes" frameborder="0" marginheight="0px" marginwidth="0px" height="1700px" width="100%px"></iframe>';
    return $css . $iframe;
}

function get_nolink()
{
    return "The page is under-construction.";
}

function getRegionId($region)
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

function get_all_block_by_region($regionid)
{
    global $language;
    $lang = $language->language;
    global $domain_info;
    $domainid = $domain_info['id'];
    $sql = "SELECT more, title_$lang 'title', body_$lang 'body',  template_block_name FROM `npfministryadmin`.`npf_blocks` WHERE `domain_id`=$domainid AND `region_id`=$regionid ORDER BY weight";
    //echo $sql;
    $result = db_query($sql);
    $html = '';
    while ($row = db_fetch_object($result)) {
        $html .= get_block_view($row->template_block_name, $row->title, $row->body, $row->more);
    }

    return $html;
}

function get_block_view($block_name, $title, $body, $more)
{
    global $language;
    $lang = $language->language;
    global $domain_info;
    $domainid = $domain_info['id'];


    //get the query for list block_name
    $sql = "SELECT `sql` FROM `npfministryadmin`.`npf_template_blocks` WHERE `name` = '{$block_name}' LIMIT 0, 1";
    $result = db_query($sql);
    $a_result = array();
    $params = array(
        'lang' => $lang,
        'domainid' => $domainid,
    );


    $t = array();
    while ($row = db_fetch_object($result)) {
        $a_result = get_object_vars($row);

        $sql = get_view_sql_query($a_result['sql'], $params);
    }
    $t['contents'] = array();
    if (!empty($sql)) {
        $result = db_query($sql);

        while ($row = db_fetch_object($result)) {
            unserializedRows($row);
            $t['contents'][] = get_object_vars($row);
        }
    }

    $t['lang'] = $lang;
    $t['title'] = $title;
    $t['body'] = $body;
    $t['more'] = $more;

    return renderPhpFile("./sites/default/files/templates/blocks/" . $block_name . "/" . $block_name . "_template_" . $lang . ".compiled", $t);
}

function get_ajax_view_content($view_name)
{
    $v_content = get_view_content($view_name);
    print $v_content;
    //die();
    drupal_page_footer();
}

function get_view_content_ref($viewuri)
{
    $tmp = explode("/", $viewuri);
    $view_name = $tmp[3];
    return get_view_content($view_name);
}

function check_uuid($guid)
{
    if (preg_match('/^\{?[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}\}?$/', $guid)) {
        return true;
    }
    return false;
}

function check_word($word, $min, $max)
{
    if (preg_match('/^[a-zA-Z]+[-a-zA-Z0-9_]{' . $min . ',' . $max . '}$/', $word)) {
        return true;
    }
    return false;
}

function check_number($number, $min, $max)
{
    if (preg_match('/^[0-9]{' . $min . ',' . $max . '}$/', $number)) {
        return true;
    }
    return false;
}

function get_view_content($view_name)
{
    $view_name = mysql_real_escape_string($view_name);
    if (!check_word($view_name, 3, 20)) {
        //return "<p>Invalid view!</p>";
    }
    global $is_right_side_bar;
    global $language;
    $lang = $language->language;
    global $domain_info;
    $domainid = $domain_info['id'];

    $args = get_args($_GET['q']); // 0 site, 1 view, 2 view_name, 3 arg0, 4 arg1, 5 arg2 ... N argN-3


    $page = isset($_GET['page']) ? $_GET['page'] : '1';
    $rows = isset($_GET['rows']) ? $_GET['rows'] : '20';
    $rows = $rows <= 99999 ? $rows : 99999;

    $offset = ($page - 1) * $rows;

    $t = isset($_GET['t']) ? $_GET['t'] : '';

    //get the query for list view_name
    $sql = "SELECT `header_{$lang}` AS header, `footer_{$lang}` AS footer, `sql_query`, `is_right_side_bar`, `is_pagination` FROM `npfministryadmin`.`npf_view_contents` WHERE `name` = '{$view_name}' LIMIT 0, 1";
    $result = db_query($sql);
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
    while ($row = db_fetch_object($result)) {

        $a_result = get_object_vars($row);
        $sql = get_view_sql_query($a_result['sql_query'], $params);

        $t['header'] = $a_result['header'];
        $t['footer'] = $a_result['footer'];
        $t['footer'] = $a_result['footer'];
        $is_right_side_bar = $a_result['is_right_side_bar'];
        $isPagination = $a_result['is_pagination'];
    }

    $t['contents'] = array();
    $t['paginate'] = array();
    $t['offset'] = $offset;
    $t['rows'] = $rows;

    if (!empty($sql)) {
        $result = db_query($sql);

        while ($row = db_fetch_object($result)) {
            unserializedRows($row);
            $t['contents'][] = get_object_vars($row);
        }
        if ($isPagination) {
            $t['paginate'] = get_pagination_props($sql, $page, $rows);
        }
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

    $rendered_content .= renderPhpFile("./sites/default/files/templates/views/" . $view_name . "/" . $view_name . "_template_" . $lang . ".compiled", $t);

    if ($print_btn) {
        $rendered_content .= '</div>';
    }

    if ($isPagination) {
        $paginated_content = '<div id="div-view-pagination-' . $view_name . '">';
        $paginated_content .= $rendered_content;
        $paginated_content .= '</div>';
        return $paginated_content;
    } else {
        return $rendered_content;
    }
}

function print_view()
{

}

function get_args($uri)
{
    $args = array();
    $tmp = explode("/", $uri);
    for ($i = 3; $i < sizeof($tmp); $i++) {
        $args[] = $tmp[$i];
    }
    return $args;
}

function get_pagination_props($sql, $page, $rows)
{
    $t = array();
    $sql = get_sql_row_count_statement($sql);
    //echo $sql;
    $result = db_query($sql);
    while ($row = db_fetch_object($result)) {
        //var_dump($row->cnt);
        $t['total'] = $row->cnt;
        $t['total_pages'] = ceil($t['total'] / $rows);
    }
    $t['rows'] = $rows;
    $t['page'] = $page;
    return $t;
}

function renderPagination($view_name, $pag)
{
    if (!check_word($view_name, 3, 20)) {
        return "<p>Invalid view!</p>";
    }
    if (empty($pag)) return '';
    $uri = strtok($_SERVER["REQUEST_URI"], '?');
    global $language;
    $lang = $language->language;
    $html = '<ul class="pagination">';
    $n = $pag['total_pages'];
    for ($i = 1; $i <= $n; $i++) {

        $html .= '<li>';
        if ($pag['page'] == $i) {
            $html .= '<span class="btn">' . digit_to_bangla($i, $lang) . '</span>';
        } else {
            //$html .= '<a class="btn" href="/site/view/'.$view_name.'?page='.$i.'&rows='.$pag['rows'].'">'.digit_to_bangla($i,$lang).'</a>';
            $html .= '<a class="btn" href="' . $uri . '?page=' . $i . '&rows=' . $pag['rows'] . '">' . digit_to_bangla($i, $lang) . '</a>';
        }
        $html .= '</li>';
    }
    $html .= '</ul>';
    if ($lang == 'bn') {
        $html .= '<p>সর্বমোট তথ্য: ' . digit_to_bangla($pag['total'], $lang) . '</p>';
    } else {
        $html .= '<p>Total records: ' . $pag['total'] . '</p>';
    }

    return $html;
}

function get_sql_row_count_statement($sql)
{
    $sql = strtolower($sql);
    $startSelect = strpos($sql, 'select');
    $startFrom = strpos($sql, 'from');
    $startLimit = strpos($sql, 'limit');
    $len = $startLimit - $startFrom;
    $tmp = 'select count(*) cnt ' . substr($sql, $startFrom, $len);
    return $tmp;
}

function renderView($view_ref, $params = array())
{
    $tmp = explode("/", $view_ref);
    $view_name = $tmp[3];


    global $is_right_side_bar;
    global $language;
    $lang = $language->language;
    global $domain_info;
    $domainid = $domain_info['id'];

    $offset = isset($params['offset']) ? $params['offset'] : '0';
    $rows = isset($params['rows']) ? $params['rows'] : '20';
    $t = isset($params['t']) ? $params['t'] : '';

    if (!check_word($view_name, 3, 20)) {
        return "<p>Invalid view!</p>";
    }

    //get the query for list view_name
    $sql = "SELECT `header_{$lang}` AS header, `footer_{$lang}` AS footer, `sql_query`, `is_right_side_bar` FROM `npfministryadmin`.`npf_view_contents` WHERE `name` = '{$view_name}' LIMIT 0, 1";
    $result = db_query($sql);
    $a_result = array();
    $params = array(
        'lang' => $lang,
        'domainid' => $domainid,
        'offset' => $offset,
        'rows' => $rows,
        't' => $t,
    );

    $t = array();
    while ($row = db_fetch_object($result)) {

        $a_result = get_object_vars($row);
        $sql = get_view_sql_query($a_result['sql_query'], $params);

        $t['header'] = $a_result['header'];
        $t['footer'] = $a_result['footer'];
        $t['footer'] = $a_result['footer'];
        $is_right_side_bar = $a_result['is_right_side_bar'];
    }
    $t['contents'] = array();
    if (!empty($sql)) {
        $result = db_query($sql);

        while ($row = db_fetch_object($result)) {
            unserializedRows($row);
            $t['contents'][] = get_object_vars($row);
        }
    }

    $t['lang'] = $lang;

    return renderPhpFile("./sites/default/files/templates/views/" . $view_name . "/" . $view_name . "_template_" . $lang . ".compiled", $t);
}

function unserializedRows(&$row)
{

    foreach ($row as &$col) {
        if (is_serialized($col)) {
            $col = unserialize($col);
        }
    }
}

function get_view_sql_query($sql, $params)
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

function get_contents($content_type, $content_id)
{
    if (!check_word($content_type, 3, 20)) {
        return "<p>Invalid Content Type!</p>";
    }
    if (!check_uuid($content_id)) {
        return "<p>Invalid Content Type!</p>";
    }
    $content_type = mysql_real_escape_string($content_type);
    $content_id = mysql_real_escape_string($content_id);
    global $language;
    $lang = $language->language;
    global $domain_info;
    $domainid = $domain_info['id'];

    if ($content_id == 'nolink') {
        $nolink = '<h1 class="title">Under Construction</h1>';
        $nolink .= '<p>This page is under construction. Please visit again soon!</p>';
        return $nolink;
    }

    $props = get_content_type_props($content_type, $domainid);
    if ($props == "ERROR") {
        return "Invalid content...";
    }

    $flds = unserialize($props['flds']);

    $sql = unserialize($props['sql_query']);
    $sqls = array();
    if (sizeof($sql) <= 0) {
        $sqls[] = "SELECT * FROM {npfministryadmin.npf_content_$content_type} WHERE id = '$content_id' AND domain_id = $domainid AND active = 1 AND publish = 1";
    } else {

        $params = get_defualt_params($domainid, $content_id);
        $sysflds = get_system_fields();

        $flds = get_fld_merge($sysflds, $flds);
        //var_dump($flds);
        foreach ($sql as $s) {
            $sqls[] = gen_raw_sql($content_type, $s, $flds, $params, $lang);
        }
    }
    $t = getResultValuesInVars($sqls, $flds, $lang);
    $t['lang'] = $lang;
    if ($t != false) {

        if (isset($t['content']['is_right_side_bar'])) {
            global $is_right_side_bar;
            $is_right_side_bar = $t['content']['is_right_side_bar'] | $is_right_side_bar;
        }

        $output = renderPhpFile("./sites/default/files/templates/" . $content_type . "_" . $lang . ".compiled", $t);
        $uri = generateContentEditUri($domain_info, $content_type, $content_id);
        /////////////////Edited by hafij//////////////////////
        //$output= $uri.$output;
        $output = $uri . "<div id='printable_area'>" . $output . "</div>";
        /////////////////Edited by hafij//////////////////////
        $lastupdated = getlastupdate($content_type, $content_id, $domainid, $lang);
        return $lastupdated . $output;
    }
    return "";
}


function renderContent($content_ref)
{
    global $language;
    $lang = $language->language;
    global $domain_info;
    $domainid = $domain_info['id'];
    return render_content_by_ref($domainid, $lang, $content_ref);
}

function render_content_by_ref($domainid, $lang, $content_ref)
{

    $tmp = explode("/", $content_ref);

    $content_type = $tmp[2];
    $content_id = $tmp[3];

    if (!check_word($content_type, 3, 20)) {
        return "<p>Invalid Content Type!</p>";
    }
    if (!check_uuid($content_id)) {
        return "<p>Invalid Content Type!</p>";
    }

    $props = get_content_type_props($content_type, $domainid);
    if ($props == "ERROR") {
        return "Invalid content...";
    }

    $flds = unserialize($props['flds']);

    $sql = unserialize($props['sql_query']);
    $sqls = array();
    if (sizeof($sql) <= 0) {
        $sqls[] = "SELECT * FROM {npfministryadmin.npf_content_$content_type} WHERE id = '$content_id' AND domain_id = $domainid AND active = 1 AND publish = 1";
    } else {

        $params = get_defualt_params($domainid, $content_id);
        $sysflds = get_system_fields();

        $flds = get_fld_merge($sysflds, $flds);

        foreach ($sql as $s) {
            $sqls[] = gen_raw_sql($content_type, $s, $flds, $params, $lang);
        }
    }
    $t = getResultValuesInVars($sqls, $flds, $lang);

    $t['lang'] = $lang;
    if ($t != false) {

        return renderPhpFile("./sites/default/files/templates/" . $content_type . "_" . $lang . ".compiled", $t);
    }
    return "";
}

function getResultValuesInVars($sqls, $flds, $lang)
{
    $t = array();
    foreach ($sqls as $sql) {

        $result = db_query($sql);
        $row = db_fetch_object($result);
        if ($row) {
            $row = get_object_vars($row);
            getUnserializeValues($row, $flds, $lang);

            $t['content'] = $row;

        } else {
            return false;
        }
    }

    return $t;
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


function get_lookup_value($lookuptblid, $lookupid, $lang)
{
    $sql = "SELECT name_$lang AS name FROM npfministryadmin.npf_lookups WHERE lookuptype_id = '$lookuptblid' AND id = '$lookupid' "; //-- AND domain_id = $domainid AND active = 1
    //echo $sql;
    $result = db_query($sql);
    $row = db_fetch_object($result);
    if ($row) {
        return $row->name;
    } else {
        return "";
    }
}

function get_content_type_flds($content_type, $domainid)
{
    if (!check_word($content_type, 3, 20)) {
        return "<p>Invalid Content Type!</p>";
    }
    $sql = "SELECT flds FROM {npfministryadmin.npf_content_types} WHERE name = '{$content_type}' "; //-- AND domain_id = $domainid AND active = 1
    $result = db_query($sql);
    $row = db_fetch_object($result);
    if ($row) {
        return $row->flds;
    } else {
        return "ERROR";
    }
}

function get_content_type_props($content_type, $domainid)
{
    if (!check_word($content_type, 3, 20)) {
        return "<p>Invalid Content Type!</p>";
    }
    global $is_right_side_bar;

    $sql = "SELECT flds, sql_query, is_right_side_bar FROM {npfministryadmin.npf_content_types} WHERE name = '{$content_type}' "; //-- AND domain_id = $domainid AND active = 1
    $result = db_query($sql);
    $row = db_fetch_object($result);
    if ($row) {
        $tmp['flds'] = $row->flds;
        $tmp['sql_query'] = $row->sql_query;
        $is_right_side_bar = $row->is_right_side_bar;
        return $tmp;
    } else {
        return "ERROR";
    }
}

function renderPhpFile($filename, $vars = null)
{
    global $domain_info;
    if (is_array($vars) && !empty($vars)) {
        extract($vars);
    }
    ob_start();
    include $filename;
    return ob_get_clean();
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

function get_defualt_params($domain_id, $id)
{
    $params = array(
        'id' => $id,
        'domain_id' => $domain_id,
        'active' => 1,
        'publish' => 1
    );
    return $params;
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
    return $flds;
}


function is_serialized($data)
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

function teaser_text($text, $charLimit = 100)
{
    //mb_internal_encoding("UTF-8");
    $teaserText = $text;
    if (mb_strlen($text) >= $charLimit) {
        $teaserText = mb_substr($text, 0, $charLimit) . '...';
    }

    return $teaserText;
}

function teaser($content_ref, $text, $charLimit = 100)
{
    $teaserText = $text;
    if (mb_strlen($text) >= $charLimit) {
        $teaserText = mb_substr($text, 0, $charLimit) . '... <a class="btn" href="' . $content_ref . '">more</a>';
    }
    return $teaserText;

    /*
    $wordLimit = 7;
    $text = "The quick brown fox jumped over the lazy dog";
    $teaserText = '';

    $words = explode(' ',$text);
    $i = 0;
    while($i < $wordLimit)
        {
        $i++;
        $teaserText .= $words[$i]." ";
        }
    $teaserText .= "... <a href="<your more link>">more</a>";
    */
}

function renderImagePath($contentType, $uploadpath, $filefield)
{
    if (is_serialized($filefield)) {
        $filefield = unserialize($filefield);
        //var_dump($filefield);
    }
    if (!isset($filefield['name'])) {
        $filefield = $filefield[0];
    }
    if (!empty($filefield['name'])) {
        global $domain_info;
        $uploadpath = str_replace("-", '_', $uploadpath);
        $base_path = '/sites/default/files/files/' . $domain_info['subdomain'] . '/' . $contentType . '/' . $uploadpath . '/' . $filefield['name'];
        $file_path = base_path() . $base_path;
        return $base_path;
    } else {
        return '';
    }
}

function renderLink($lnk, $lang)
{
    if (is_serialized($lnk)) {
        $lnk = unserialize($lnk);
    }
    if (!isset($lnk['link'])) {
        $lnk = $lnk[0];
    }
    $custom_title = '';
    $checkExternal = $lnk['link'];
    if ($checkExternal[0] == '/') {
        $custom_title_check = implode('-', explode(" ", $lnk['caption_' . $lang]));
        $title_check = '';//end(explode('/', $lnk['link']));
        if ($title_check != $custom_title_check) {
            $custom_title = '/' . implode('-', explode("/", $custom_title_check));
        } else {
            $custom_title = '';
        }
    }

    //return '<a href="' . $lnk['link'] . $custom_title . '">' . $lnk['caption_' . $lang] . '</a>';
    return '<a href="' . $lnk['link'] . '">' . $lnk['caption_' . $lang] . '</a>';

}

/*============ Start Add title with URL For Service Box ===========*/

function renderLinkServiceBox($lnk, $lang)
{

    if (is_serialized($lnk)) {
        $lnk = unserialize($lnk);
        //var_dump($filefield);
    }
    if (!isset($lnk['link'])) {
        $lnk = $lnk[0];
    }
    $custom_title = '';
    $checkExternal = $lnk['link'];
    if (isset($checkExternal[0]) and $checkExternal == '/') {
        $custom_title_check = implode('-', explode(" ", $lnk['caption_' . $lang]));
        $title_check = (explode('/', $lnk['link']));
        $title_check = end($title_check);
        if ($title_check != $custom_title_check) {
            $custom_title = '/' . implode('-', explode("/", $custom_title_check));
        } else {
            $custom_title = '';
        }
    }

    return '<a href="' . $lnk['link'] . $custom_title . '">' . $lnk['caption_' . $lang] . '</a>';
    //return '<a href="'.$lnk['link'].'">'.$lnk['caption_' . $lang].'</a>';

}

/*============ End Add title with URL For Service Box ===========*/


function renderLinkBy($contentType, $id, $title)
{
    $pageUrl = '/site/' . $contentType . '/' . $id;
    $custom_title_check = implode('-', explode(" ", $title));
    $title_check = explode('/', $pageUrl);
    $title_check = end($title_check);
    if ($title_check != $custom_title_check) {
        $custom_title = '/' . implode('-', explode("/", $custom_title_check));
    } else {
        $custom_title = '';
    }
    //return '<a href="' . $pageUrl . $custom_title . '">' . $title . '</a>';
    return '<a href="' . $pageUrl . '">' . $title . '</a>';
}

function renderContentRef($contentType, $id, $title)
{
    return '<a href="/' . $contentType . '/' . $id . '">' . $title . '</a>';
}

/*function getFileUrl($contentType, $uploadpath, $filefield){
    global $domain_info;
    $uri = getFileUri($contentType, $uploadpath, $filefield);
    $url = 'http://'.$domain_info['subdomain'].'/'.$uri;
    return $url;
}

function getFileUri($contentType, $uploadpath, $filefield){
    if(is_serialized( $filefield )){
        $filefield = unserialize( $filefield );
    }
    if(!isset($filefield['name'])){
        $filefield = $filefield[0];
    }
    if(!empty($filefield['name'])){
        global $domain_info;
        $uploadpath = str_replace("-", '_', $uploadpath);
        $uri = '/sites/default/files/files/'.$domain_info['subdomain'].'/'.$contentType.'/'.$uploadpath.'/'.$filefield['name'];
        return $uri;
    }else{
        return '';
    }
}*/
function getFileUrl($contentType, $uploadpath, $filefield, $domain_name = null)
{

    if (empty($domain_name)) {
        global $domain_info;
        $domain_name = $domain_info['subdomain'];
    }

    $uri = getFileUri($contentType, $uploadpath, $filefield, $domain_name);
    $url = 'http://' . $domain_name . '/' . $uri;
    return $url;
}

function getFileUri($contentType, $uploadpath, $filefield, $domain_name = null)
{
    if (is_serialized($filefield)) {
        $filefield = unserialize($filefield);
    }
    if (!isset($filefield['name'])) {
        $filefield = $filefield[0];
    }
    if (!empty($filefield['name'])) {
        if (empty($domain_name)) {
            global $domain_info;
            $domain_name = $domain_info['subdomain'];
        }
        $uploadpath = str_replace("-", '_', $uploadpath);
        $uri = '/sites/default/files/files/' . $domain_name . '/' . $contentType . '/' . $uploadpath . '/' . $filefield['name'];
        return $uri;
    } else {
        return '';
    }
}

function getFileExt($file_path)
{
    $path_parts = pathinfo($file_path);
    return $path_parts['extension'];
}

function getFileExtIcon($file_path, $res = 32)
{
    $file_ext = getFileExt($file_path);
    $icon_file = $file_ext . '.png';
    $icon_path = '/img/file-icons/' . $res . 'px';
    return $icon_path . '/' . $icon_file;

}

function base_path()
{
    return '/';
}

function getLanguage()
{
    $di = \Phalcon\DI::getDefault();
    return $di->get('view')->lang;
}

function renderDownloadLink($contentType, $uploadpath, $filefield, $is_caption = false, $domain_name = null, $icon_size = 32)
{
    if (is_serialized($filefield)) {
        $filefield = unserialize($filefield);
        //var_dump($filefield);
    }
    if (!isset($filefield['name'])) {
        $filefield = $filefield[0];
    }
    if (!empty($filefield['name'])) {
        if ($domain_name == null) {
            $domain_info = getDomain();
            $domain_name = $domain_info['subdomain'];
        }
        $uploadpath = str_replace("-", '_', $uploadpath);
        $base_path = 'files/' . $domain_name . '/' . $contentType . '/' . $uploadpath . '/' . $filefield['name'];
        $file_path = base_path() . $base_path;
        $url_path = 'http://' . $domain_name . '/' . $base_path;


        $t = "";
        $lang = getLanguage();

        $f_cap = $filefield['name'];
        if (!empty($filefield['caption_' . $lang])) {
            $f_cap = $filefield['caption_' . $lang];
        }

        if ($is_caption) {
            $ext_icon = getFileExtIcon($file_path, 16);
            $t = '<a href="' . $url_path . '"><img src="' . $ext_icon . '" alt="' . $f_cap . '" class="file-icon"/> ' . $f_cap . '</a>';
        } else {
            $ext_icon = getFileExtIcon($file_path, $icon_size);
            $t = '<a href="' . $url_path . '" title="' . $f_cap . '"><img src="' . $ext_icon . '" alt="' . $f_cap . '" class="file-icon"/></a>';
        }
        return $t;
    } else {
        return '';
    }
}

function renderFileViewer($contentType, $uploadpath, $filefields, $domain_name = null)
{
    $filefields = array_values($filefields);
    $content = '';
    if (sizeof($filefields) > 1) {
        $content .= '<ul class="multifile-viewer-list">';
        for ($i = 0; $i < sizeof($filefields); $i++) {
            if (!empty($filefields[$i]['name'])) {
                $content .= '<li class="' . ($i == 0 ? "active" : "") . '">';
                $content .= renderDownloadLink($contentType, $uploadpath, $filefields[$i], true, $domain_name);
                $url = 'http://docs.google.com/viewer?url=' . getFileUrl($contentType, $uploadpath, $filefields[$i], $domain_name) . '&embedded=true';
                $content .= ' <a class="file-btn view" href="javascript:;" onclick="$(this).parent().parent(\'ul\').children(\'li\').removeClass(\'active\');$(this).parent(\'li\').addClass(\'active\');$(\'#iframe-fileviewer > iframe\').attr(\'src\',\'' . $url . '\')">view</a>';
                $content .= '</li>';
            }
        }
        $url = 'http://docs.google.com/viewer?url=' . getFileUrl($contentType, $uploadpath, $filefields[0], $domain_name) . '&embedded=true';
        $content .= '</ul>';
        $content .= '<div id="iframe-fileviewer"><iframe src="' . $url . '" width="100%" height="780" style="border: none;"></iframe></div>';
    } else {
        if (!empty($filefields[0]['name'])) {
            $content .= renderDownloadLink($contentType, $uploadpath, $filefields[0], true, $domain_name);
            $content .= renderGoogleDocViewer($contentType, $uploadpath, $filefields[0], $domain_name);
        }
    }

    return $content;
}

function renderGoogleDocViewer($contentType, $uploadpath, $filefield, $domain_name = null)
{

    //$file_path = getFileUrl($contentType, $uploadpath, $filefield);
    //$file_path = 'http://cabinet.portal.gov.bd/sites/default/files/files/cabinet.portal.gov.bd/notification_circular/673abcf5_faa6_416b_ab54_ed1f226b06ca/bn_626.pdf';
    $file_path = getFileUrl($contentType, $uploadpath, $filefield, $domain_name);
    $p_f_path = rawurlencode($file_path);
    return '<iframe src="http://docs.google.com/viewer?url=' . $file_path . '&embedded=true" width="100%" height="780" style="border: none;"></iframe>';

}

function getThumbnailPath($contentType, $uploadpath, $filefield)
{
    return getImagePath($contentType, $uploadpath, $filefield, "thumbnail");
}

function getImagePath($contentType, $uploadpath, $filefield, $type = false)
{
    if (is_serialized($filefield)) {
        $filefield = unserialize($filefield);
        //var_dump($filefield);
    }
    if (!isset($filefield['name'])) {
        $filefield = $filefield[0];
    }
    if (!empty($filefield['name'])) {
        global $domain_info;
        $uploadpath = str_replace("-", '_', $uploadpath);
        if ($type == "thumbnail") {
            $base_path = 'http://' . $domain_info['subdomain'] . '/sites/default/files/files/' . $domain_info['subdomain'] . '/' . $contentType . '/' . $uploadpath . '/thumbnail/' . $filefield['name'];
        } else {
            $base_path = 'http://' . $domain_info['subdomain'] . '/sites/default/files/files/' . $domain_info['subdomain'] . '/' . $contentType . '/' . $uploadpath . '/' . $filefield['name'];
        }
        //$file_path = base_path().$base_path;
        return $base_path;
    } else {
        return '';
    }
}

function getDomain()
{
    $name = $_SERVER['HTTP_HOST'];
    return (array)NpfDomains::findFirstBySubdomain($name);
}

function renderImage($contentType, $uploadpath, $filefield, $width = '', $height = '')
{
    $domain_info = getDomain();
    if (is_serialized($filefield)) {
        $filefield = unserialize($filefield);
        //var_dump($filefield);
    }
    if (!isset($filefield['name'])) {
        $filefield = $filefield[0];
    }
    if (!empty($filefield['name'])) {

        $uploadpath = str_replace("-", '_', $uploadpath);
        $base_path = 'http://' . $domain_info['subdomain'] . '/files/' . $domain_info['subdomain'] . '/' . $contentType . '/' . $uploadpath . '/' . $filefield['name'];
        //$file_path = base_path().$base_path;
        return '<img src="' . $base_path . '" alt="" width="' . $width . '" height="' . $height . '"/>';
    } else {
        return '';
    }
}

function renderImageThumbnil($contentType, $uploadpath, $filefield)
{
    if (is_serialized($filefield)) {
        $filefield = unserialize($filefield);
        //var_dump($filefield);
    }
    if (!isset($filefield['name'])) {
        $filefield = $filefield[0];
    }
    if (!empty($filefield['name'])) {
        global $domain_info;
        $uploadpath = str_replace("-", '_', $uploadpath);
        $base_path = '/sites/default/files/files/' . $domain_info['subdomain'] . '/' . $contentType . '/' . $uploadpath . '/thumbnail/' . $filefield['name'];
        $file_path = base_path() . $base_path;
        return '<img src="' . $base_path . '" alt=""/>';
    } else {
        return '';
    }
}

function makeArrayGroup($group, $data)
{

    $group_size = sizeof($group);
    $result = null;
    foreach ($data as $dt) {
        $tmp1 = array();
        for ($st = $group_size - 1; $st >= 0; $st--) {
            $tmp2 = array();
            $key_val = $dt[$group[$st]];
            $tmp2[$key_val] = $tmp1;
            $tmp1 = $tmp2;
        }
        if ($result == null) {
            $result = $tmp1;
        } else {
            $result = array_merge_recursive($result, $tmp1);
        }
    }
    makeArrayGroupDFS($group[$group_size - 1], $data, $result);
    return $result;
}

function makeArrayGroupDFS($f, $data, &$tmp)
{
    foreach ($tmp as $key => &$val) {
        if (is_array($val) && (sizeof($val) > 0)) {
            makeArrayGroupDFS($f, $data, $val);
        } else {
            $tmp_key = makeArrayGroupSearch($data, $f, $key);
            $tmp[$key] = $tmp_key;
        }
    }
}

function makeArrayGroupSearch($array, $key, $value)
{
    $results = array();
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
        foreach ($array as $subarray) {
            $results = array_merge($results, makeArrayGroupSearch($subarray, $key, $value));
        }
    }
    return $results;
}

function digit_to_bangla($digits, $lang)
{
    if ($lang != 'bn') return $digits;
    $dig_arr = str_split($digits);
    $dig_bn = '';
    foreach ($dig_arr as $dig) {
        switch ($dig) {
            case '0':
                $dig_bn .= '&#x09E6;';
                break;
            case '1':
                $dig_bn .= '&#x09E7;';
                break;
            case '2':
                $dig_bn .= '&#x09E8;';
                break;
            case '3':
                $dig_bn .= '&#x09E9;';
                break;
            case '4':
                $dig_bn .= '&#x09EA;';
                break;
            case '5':
                $dig_bn .= '&#x09EB;';
                break;
            case '6':
                $dig_bn .= '&#x09EC;';
                break;
            case '7':
                $dig_bn .= '&#x09ED;';
                break;
            case '8':
                $dig_bn .= '&#x09EE;';
                break;
            case '9':
                $dig_bn .= '&#x09EF;';
                break;
            default:
                $dig_bn .= $dig;
        }
    }
    $dig_bn = str_replace("th", "", $dig_bn);

    $dig_bn = str_replace("January", "জানুয়ারি", $dig_bn);
    $dig_bn = str_replace("February", "ফেব্রুয়ারি", $dig_bn);
    $dig_bn = str_replace("March", "মার্চ", $dig_bn);
    $dig_bn = str_replace("April", "এপ্রিল", $dig_bn);
    $dig_bn = str_replace("May", "মে", $dig_bn);
    $dig_bn = str_replace("June", "জুন", $dig_bn);
    $dig_bn = str_replace("July", "জুলাই", $dig_bn);
    $dig_bn = str_replace("Augst", "আগস্ট", $dig_bn);
    $dig_bn = str_replace("September", "সেপ্টেম্বর", $dig_bn);
    $dig_bn = str_replace("October", "অক্টোবর", $dig_bn);
    $dig_bn = str_replace("November", "নভেম্বর", $dig_bn);
    $dig_bn = str_replace("December", "ডিসেম্বর", $dig_bn);
    return $dig_bn;
}

function hitcount($domainid)
{
    return 1;
    //return;
    $page = $_SERVER['HTTP_HOST'] . '' . $_SERVER['REQUEST_URI'];
    //echo $page;
    //return;
    // or use $_SERVER['PHP_SELF']

    $maxrows = 50;
    $sql = "SELECT page, count FROM npfministryadmin.npf_hit_counter_hits WHERE page = '%s' AND domain_id = '$domainid' limit 1";
    $result = db_query($sql, array($page));

    if (mysql_num_rows($result)) {
        //A counter for this page  already exsists. Now we have to update it.
        $updatecounter = db_query("UPDATE npfministryadmin.npf_hit_counter_hits SET count = count+1 WHERE page = '%s' AND domain_id = '$domainid'", array($page));
        if (!$updatecounter) {
            return "Can't update the counter : ";
        }

    } else {
        // This page did not exsist in the counter database. A new counter must be created for this page.

        $insert = db_query("INSERT INTO npfministryadmin.npf_hit_counter_hits (page, count,domain_id)VALUES ('%s', '1', '$domainid')", array($page));

        if (!$insert) {
            return "Can't insert counter data. ";
        }
    }


    // gather user data
    /*$ip = $_SERVER["REMOTE_ADDR"];
    $agent = $_SERVER["HTTP_USER_AGENT"];
    $datetime = date("Y/m/d") . ' ' . date('H:i:s');


    if (!mysql_num_rows(db_query("SELECT ip_address FROM npfministryadmin.npf_hit_counter_info WHERE ip_address = '$ip'  AND domain_id = '$domainid' limit 1"))) // check if the IP is in database
    {
        // if not , add it.
        $adddata = db_query("INSERT INTO npfministryadmin.npf_hit_counter_info (ip_address, user_agent, datetime,domain_id) VALUES('$ip' , '$agent','$datetime', '$domainid' ) ");
        if (!$adddata) {
            return 'Could not add IP.';
        }
    }

    /*$result = db_query("SELECT * FROM npfministryadmin.npf_hit_counter_info WHERE  domain_id = '$domainid'");
    $num_rows = mysql_num_rows($result);
    $to_delete = $num_rows - $maxrows;
    if ($to_delete > 0) {
        for ($i = 1; $i <= $to_delete; $i++) {
            $sql = "DELETE FROM npfministryadmin.npf_hit_counter_info WHERE  domain_id = '$domainid' ORDER BY id LIMIT 1";
            $delete = mysql_query($sql);
            if (!$delete) {
                return 'Internal Fatal Error!';
            }
        }
    }*/


    // number of visitors
    $count = 0;
    $sql = "SELECT sum(count) AS count FROM npfministryadmin.npf_hit_counter_hits WHERE  domain_id = '$domainid'";
    $result = db_query($sql);
    $row = db_fetch_object($result);
    if ($row) {
        $count = $row->count;
    }
    //return floor($count / 3);
    //return $count;

}

function getGoogleAnalytics()
{
    global $domain_info;
    if ($domain_info['id'] == 5934) {
        $trackingId = "'UA-58123229-1'";
        $ga = <<<EOT
    <script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', $trackingId, 'auto');
    ga('send', 'pageview');

</script>
EOT;
        return $ga;
    }
}

/*===============Site Map work Start=================*/
function initSitemap($tree, $root)
{
    global $domain_info;
    global $language;
    $domainid = $domain_info['id'];
    $lang = $language->language;

    //get main menu items
    $sql = "SELECT id, title_bn,title_en, parent_id,link_type,link_path,router_path,external,has_children,depth,active FROM npfministryadmin.npf_menus WHERE   active=1 AND domain_id = '$domainid' ORDER BY depth, weight;";
    $resource = db_query($sql);
    $title = 'title_' . $lang;
    $caption = 'caption_' . $lang;
    while ($result = mysql_fetch_array($resource)) {
        $menuItem = array(
            'parent' => count(explode('-', $result['parent_id'])) > 2 ? $result['parent_id'] : $root,
            'title' => $result[$title],
            'link' => $result['link_path']
        );
        $tree[$result['id']] = $menuItem;
    }

    return $tree;
}

function addLinks($sql, &$tree, $section, $external = true, $root = 'pmo')
{
    global $language;
    $lang = $language->language;
    $caption = 'caption_' . $lang;
    $title = 'title_' . $lang;

    $resource = db_query($sql);
    switch ($section) {
        case 'service_box':
            while ($result = mysql_fetch_array($resource)) {
                $tree[$result['id']] = array(
                    'parent' => $root,
                    'title' => $result[$title],
                    'link' => 'nolink'
                );
                for ($i = 1; $i < 5; $i++) {
                    $linkKey = 'link' . $i;
                    if (!empty($result[$linkKey])) {
                        $link = unserialize($result[$linkKey])[0];
                        $tree[rand(1111111111, 9999999999)] = array(
                            'parent' => $result['id'],
                            'title' => $link[$caption],
                            'link' => $link['link']
                        );
                    }
                }
            }
            break;
        default:
            while ($result = mysql_fetch_array($resource)) {
                $link = unserialize($result['link'])[0];
                $tree[$result['id']] = array(
                    'parent' => $section,
                    'title' => $link[$caption],
                    'link' => $link['link'],
                    'external' => $external
                );
            }

    }

    return $tree;
}

function parseAndPrintTree($root, $tree)
{

    if (!is_null($tree) && count($tree) > 0) {
        echo '<ul>';
        foreach ($tree as $child => $parent) {
            $record = $parent;
            if ($record['link'] == '[front]')
                $record['link'] = '/';

            if ($record['parent'] == $root) {
                unset($tree[$child]);
                echo '<li>';
                if ($record['link'] != 'nolink') {
                    /*============= Start Tappware =============*/
                    $checkExternal = $record['link'];

                    if ($checkExternal[0] != '/') {
                        echo '<a target="_blank" href="' . $record['link'] . '">' . $record['title'] . '</a>';
                    } else {
                        $ownUrl = rawurldecode($_SERVER['HTTP_HOST']);

                        if ($record['link'] == "/") {
                            echo '<a href="' . $record['link'] . '">' . $record['title'] . '</a>';
                        } else {
                            $custom_title_check = implode('-', explode(" ", $record['title']));
                            $title_check = end(explode('/', $record['link']));
                            if ($title_check != $custom_title_check) {
                                $custom_title = '/' . implode('-', explode("/", $custom_title_check));
                            } else {
                                $custom_title = '';
                            }
                            echo '<a href="' . $record['link'] . $custom_title . '">' . $record['title'] . '</a>';
                        }

                    }
                    /*============= End Tappware =============*/
                } else
                    echo '<span>' . $record['title'] . '</span>';
                parseAndPrintTree($child, $tree);
                echo '</li>';
            }
        }
        echo '</ul>';
    }
}

/*===============Site Map work End=================*/


/*=== Create XML and save site map Start===== */

function createXML($root, $tree)
{

    global $domain_info;
    if (!is_null($tree) && count($tree) > 0) {

        foreach ($tree as $child => $parent) {

            $record = $parent;
            if ($record['link'] == '[front]')
                $record['link'] = '/';

            if ($record['parent'] == $root) {
                unset($tree[$child]);

                $internal_link = substr($record['link'], 0, 1);
                if (($record['link'] != 'nolink' AND $record['link'] != '/') AND $internal_link == '/') {
                    $GLOBALS['str'] .= "<url>";

                    $custom_title_check = implode('-', explode(" ", $record['title']));
                    $title_check = end(explode('/', $record['link']));
                    if ($title_check != $custom_title_check) {
                        $custom_title = '/' . $custom_title_check;
                    } else {
                        $custom_title = '';
                    }

                    //$internal_link = substr($record['link'], 0, 1);

                    $domain_subdomain = $domain_info['subdomain'];

                    $site_subdomain = str_replace(".portal.", ".", $domain_subdomain);

                    $GLOBALS['str'] .= "<loc>http://www." . $site_subdomain . $record['link'] . $custom_title . "</loc>";

                    $GLOBALS['str'] .= '<changefreq>monthly</changefreq>';
                    $GLOBALS['str'] .= '<priority>0.85</priority>';
                    $GLOBALS['str'] .= "</url>";
                }

                createXML($child, $tree);
            }
        }

    }
    return $GLOBALS['str'];
}


/*=============== Create XML and save site map End======================= */
?>