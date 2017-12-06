<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

use Vokuro\Models\NpfContentTypes;
/**
 * Vokuro\Models\Contents
 *
 * All the users registered in the application
 */
class Contents extends Model
{


    public function getSource()
    {
        return 'npf_content_album';
    }

    // Content Related Queries
    public static function genInsertColVals($edit, $flds, &$cols, &$vals)
    {
        //var_dump($vals);
        foreach ($flds as $fld) {
            if (Contents::excludeCols($fld['name'])) {
                continue;
            }
            if ($fld['type'] == "text" || $fld['type'] == "htmltext") {
                $cols[] = $fld['name'] . "_bn";
                $cols[] = $fld['name'] . "_en";
                $vals[] = ":" . $fld['name'] . "_bn";
                $vals[] = ":" . $fld['name'] . "_en";
            }
//            else if($fld['type']=="int" || $fld['type']=="htmltext"){
//                $cols[] = $fld['name'];
//            }
            else {
                $cols[] = $fld['name'];
                if ($fld['name'] == 'created' && !$edit) {
                    $vals[] = 'NOW()';
                    continue;
                }
                if ($fld['name'] == 'lastmodified') {
                    $vals[] = 'NOW()';
                    continue;
                }
                $vals[] = ":" . $fld['name'] . "";

            }
        }
    }
    public static function genUpdateColVals($edit, $flds, &$cols, &$vals)
    {
        //var_dump($vals);
        foreach ($flds as $fld) {
            if (Contents::excludeCols($fld['name'])) {
                continue;
            }
            if ($fld['type'] == "text" || $fld['type'] == "htmltext") {
                $cols[] = $fld['name'] . "_bn";
                $cols[] = $fld['name'] . "_en";
                $vals[] = ":" . $fld['name'] . "_bn";
                $vals[] = ":" . $fld['name'] . "_en";
            }
//            else if($fld['type']=="int" || $fld['type']=="htmltext"){
//                $cols[] = $fld['name'];
//            }
            else {
                $cols[] = $fld['name'];
                if ($fld['name'] == 'lastmodified') {
                    $vals[] = 'NOW()';
                    continue;
                }
                $vals[] = ":" . $fld['name'] . "";

            }
        }
    }

    public static function excludeCols($col)
    {
        switch ($col) {
            case "office_id":
            case "menu_id":
            case "userpermissionsids":
                return true;
        }
        return false;
    }
    public static function genInsertStatement($edit, $contentTypeName, $flds)
    {
        $cols = array();
        $vals = array();

        $sysflds = Contents::get_system_fields();
        $flds = array_merge($sysflds, $flds);
//        var_dump($flds);
        Contents::genInsertColVals($edit, $flds, $cols, $vals);
        //var_dump($cols);
        //var_dump($vals);
        $sql_cols = implode(",", $cols);
        $sql_vals = implode(",", $vals);

        $phql = "INSERT INTO npf_content_$contentTypeName ($sql_cols) "
            . "VALUES ($sql_vals)";
        return $phql;
    }
    public static function genUpdateStatement($edit, $contentTypeName, $flds, $id)
    {

        $cols = array();
        $vals = array();

        $sysflds = Contents::get_system_fields();
        unset($sysflds['created']);
        unset($sysflds['createdby']);
        unset($sysflds['id']);
        $flds = array_merge($sysflds, $flds);
//        var_dump($flds);
        Contents::genInsertColVals($edit, $flds, $cols, $vals);
//        var_dump($cols);
//        var_dump($vals);
        $sql_cols = implode(",", $cols);
        $sql_vals = implode(",", $vals);
//        var_dump($cols);
        $phql = '';
        $phql = "UPDATE npf_content_$contentTypeName SET ";
        $phql .= $cols[1] . " = " . $vals[1];
        for ($i = 2; $i < sizeof($cols); $i++) {
            if ( ($cols[$i] == 'id') || ($cols[$i] == 'created') || ($cols[$i] == 'version') || ($cols[$i] == 'createdby')) {
                continue;
            }
            $phql .= " ," . $cols[$i] . " = " . $vals[$i];
        }
        $phql .= " WHERE id='$id' ";
//        echo $phql;
        return $phql;
    }
    public static function prepareFieldValues($flds, &$fldVals)
    {
        foreach ($flds as $fld) {
            switch ($fld['type']) {
                case 'multiselect':
                    if (isset($fldVals[$fld['name']])) {
                        $fldVals[$fld['name']] = implode(',', $fldVals[$fld['name']]);
                    } else {
                        $fldVals[$fld['name']] = '';
                    }
                    break;
                case 'number_integer':
                case 'number_long':
                case 'number_decimal':
                    if ($fldVals[$fld['name']] == '') {
                        $fldVals[$fld['name']] = 0;
                    }
                    break;
                case 'date':
                case 'datetime':
                    if ($fldVals[$fld['name']] == '') {
                        $fldVals[$fld['name']] = null;
                    }
                    break;
                case "text":
                case "htmltext":
                    break;
                default:
                    if (is_array($fldVals[$fld['name']])) {
                        $fldVals[$fld['name']] = serialize($fldVals[$fld['name']]);
                    }
                    if ($fldVals[$fld['name']] == '') {
                        $fldVals[$fld['name']] = null;
                    }
                    break;
            }
        }
    }
    public static function deleteById($content_type, $id)
    {
        $sql = "DELETE FROM npf_content_$content_type WHERE id = '$id'";
        $content = new Contents();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function deactivateAllContent($edit, $contentTypeName, $id)
    {

        // $sql = "UPDATE npf_content_$contentTypeName SET active = 0 WHERE id = '$id'";
        // $content = new Contents();
        // return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }

    public static function updateContent($edit, $contentTypeName, $flds, $fldVals)
    {


        $id = $fldVals['id'];
        $flg = Contents::ifContentExist($contentTypeName, $id);
        $flds = Contents::get_active_fields($flds);

        if ($edit) {
            Contents::deactivateAllContent($edit, $contentTypeName . '_version', $fldVals['id']);
        } else {
        }


        $fldVals['active'] = '1';


        $phql = Contents::genInsertStatement($edit, $contentTypeName . '_version', $flds);
        Contents::prepareFieldValues($flds, $fldVals);
        Contents::prepareDefaultVals($flds, $fldVals);

        $content = new Contents();

        $tmp['result'] = new Resultset(null, $content, $content->getReadConnection()->query($phql, $fldVals));

        //return;

        $phql = '';
        if (!$flg) {
            $phql = Contents::genInsertStatement($edit, $contentTypeName, $flds);
            //Contents::prepareFieldValues($flds, $fldVals);

        } else {

            var_dump($fldVals);

            $phql = Contents::genUpdateStatement($edit, $contentTypeName, $flds, $id);
            unset($fldVals['id']);
            unset($fldVals['created']);
            unset($fldVals['createdby']);
            //Contents::prepareFieldValues($flds, $fldVals);
        }


//        Contents::prepareDefaultVals($flds, $fldVals);
//        var_dump($fldVals);
        $content = new Contents();

        $tmp['result'] = new Resultset(null, $content, $content->getReadConnection()->query($phql, $fldVals));


        return $tmp;
    }

    public static function setDomainLastContentUpdate($did)
    {
        $content = new Contents();

        $phql = "UPDATE npf_domains SET last_content_updated = NOW() WHERE id = :did";
        $tmp['result'] = new Resultset(null, $content, $content->getReadConnection()->query($phql, array('did' => $did)));

        return $tmp;
    }
    public static function prepareDefaultVals($flds, &$fldVals)
    {

        foreach ($flds as $fld) {
            switch ($fld['type']) {
                case 'multiselect':
                    if (!isset($fldVals[$fld['name']])) {
                        $fldVals[$fld['name']] = '';
                    }
                    break;
                case 'number_integer':
                case 'number_long':
                case 'number_decimal':
                    $fldVals[$fld['name']] = null;
                    break;
                case 'date':
                case 'datetime':
                    $fldVals[$fld['name']] = null;
                    break;
            }
        }

    }

    public static function ifContentExist($contentType, $id)
    {

        $sql = "SELECT id FROM npf_content_$contentType WHERE `id`='$id'";
//        echo $sql;

        $content = new Contents();
        $contentValues = new Resultset(null, $content, $content->getReadConnection()->query($sql));
//        echo $contentValues->count();
        if ($contentValues->count() <= 0) {

            return false;
        }
        return true;
    }
    public static function loadContentValues($contentType, $id, $version, $flds)
    {

        $sql = "SELECT * FROM npf_content_$contentType WHERE `id`='$id' AND `version`='$version' ORDER BY `version` DESC  LIMIT 0, 1";
        $content = new Contents();
        $contentValues = new Resultset(null, $content, $content->getReadConnection()->query($sql));
        //echo $contentValues->count();
        if ($contentValues->count() <= 0) {
            return false;
        }
        $contentValues = get_object_vars($contentValues[0]);

        Contents::getUnserializeFlds($contentValues, $flds);
        return $contentValues;
    }

    // ContentType related Queries
    public static function getContentTypeProperties($contentType)
    {

        $sql = "SELECT `name`, `human_name`, `use_title`, `use_body`, `flds` FROM npf_content_types WHERE `name`='$contentType'";
        $content = new Contents();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function getContentList($contentTypeName, $domain_id)
    {

        $sql = "
                SELECT `id`, `title_bn`, `created`, `lastmodified`, `createdby`, `lastmodifiedby`, `active`
                FROM `npf_content_$contentTypeName` WHERE `domain_id` = $domain_id
               ";
        $content = new Contents();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function getContentListPage($contentTypeName, $domain_id, $limit, $page, $fldLst = ',')
    {

        $offset = $limit * ($page - 1);

        $sql = "
                SELECT `id` , `version` $fldLst `publish`
                FROM `npf_content_$contentTypeName` WHERE `domain_id` = $domain_id AND `active` = 1
                ORDER BY `created` DESC
                LIMIT $offset, $limit
               ";
        $content = new Contents();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function getContentListPageCount($contentTypeName, $domain_id)
    {

        $sql = "
                SELECT count(`id`) 'cnt' FROM `npf_content_$contentTypeName` WHERE `domain_id` = $domain_id AND `active` = 1
               ";
        $content = new Contents();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function getContentVersionPage($contentTypeName, $id, $limit, $page)
    {

        $offset = $limit * ($page - 1);
        $sql = "
                SELECT `id`,`version`, `title_bn`, `created`, `lastmodified`, `createdby`, `lastmodifiedby`, `version`, `publish`, `active`
                FROM `npf_content_$contentTypeName` WHERE `id` = '$id' ORDER BY `version` DESC LIMIT $offset, $limit
               ";
        $content = new Contents();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function getContentVersionPageCount($contentTypeName, $id)
    {

        $sql = "
                SELECT count(`id`) 'cnt' FROM `npf_content_$contentTypeName` WHERE `id` = '$id'
               ";
        $content = new Contents();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }

    public static function get_active_fields($flds)
    {

        $active_flds = array();

        $flds = unserialize($flds);
        foreach ($flds as $fld) {
            if ($fld['active'] == '1') {
                $active_flds[] = $fld;
            }
        }
        return $active_flds;
    }

    // ** Content Type Part **//
    public static function createContentTypeTable($contentTypeName, $flds)
    {

        $sql = Contents::generateContentTypeTableCreateSql($contentTypeName, $flds);

        return Contents::run_sql($sql);
    }
    public static function alterContentTypeTable($contentTypeName, $oldflds, $newflds)
    {
        $new_flds = Contents::get_new_flds($oldflds, $newflds);
        foreach ($new_flds as $newfld) {
            $sql = Contents::gen_alter_statement($contentTypeName, $newfld);
            Contents::run_sql($sql);
        }
    }

    public static function run_sql($sql)
    {
        $contentType = new Contents();
        return new Resultset(null, $contentType, $contentType->getReadConnection()->query($sql));
    }
    private static function generateContentTypeTableCreateSql($contentTypeName, $flds)
    {

        $sysflds = Contents::get_system_fields();
        $flds = array_merge($sysflds, $flds);

        $tbl = " CREATE TABLE npf_content_" . $contentTypeName;


        $tbl .= " (

		  ";

        foreach ($flds as $fld) {
            $fld_name = $fld['name'];
            $fld_type = Contents::get_field_datatype($fld['type']);
            if ( ($fld['type'] == "text") || ($fld['type'] == "htmltext")) {
                $tbl .= " `" . $fld_name . "_bn` $fld_type, ";
                $tbl .= " `" . $fld_name . "_en` $fld_type, ";
            } else {
                $tbl .= " `$fld_name` $fld_type, ";
            }
        }
        $tbl .= "

		  PRIMARY KEY (`id`,`version`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
        return $tbl;
    }
    private static function gen_alter_statement($contentTypeName, $fld)
    {
        $tbl = "ALTER TABLE npf_content_" . $contentTypeName . " ";
        $fld_name = $fld['name'];
        $fld_type = Contents::get_field_datatype($fld['type']);
        if ( ($fld['type'] == "text") || ($fld['type'] == "htmltext")) {
            $tbl .= " ADD COLUMN `" . $fld_name . "_bn` $fld_type, ";
            $tbl .= " ADD COLUMN `" . $fld_name . "_en` $fld_type ";
        } else {
            $tbl .= " ADD COLUMN `$fld_name` $fld_type ";
        }
        $tbl .= ";";
        return $tbl;
    }
    public static function gen_default_sql_stmnt($contentName, $flds)
    {

        $sysflds = Contents::get_system_fields();
        $flds = array_merge($sysflds, $flds);

        $sql = ' SELECT ';

        foreach ($flds as $fld) {
            if ($fld['name'] != 'active') {
                $sql .= " " . $contentName . ".{{" . $fld['name'] . "}} '" . $fld['name'] . "', ";
            }
        }
        $sql .= " " . $contentName . ".{{active}} 'active' ";

        // domain, active, publish, id, sysinject(domain, active, publish, id)
        $sql .= " FROM {{:" . $contentName . ":}} AS " . $contentName . " ";
        $sql .= ' WHERE {{sysinject}} ';

        return $sql;
    }
    private static function get_new_flds($oldflds, $newflds)
    {
        $new_flds = array();
        $found = false;
        foreach ($newflds as $newfld) {
            foreach ($oldflds as $oldfld) {
                if ($oldfld['name'] == $newfld['name']) {
                    $found = true;
                }
            }
            if (!$found) {
                $new_flds[] = $newfld;
            }
            $found = false;
        }
        return $new_flds;
    }

    private static function get_system_fields()
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

        $flds[] = array('name' => 'userip', 'type' => 'string');
        $flds[] = array('name' => 'useragent', 'type' => 'string');
        $flds[] = array('name' => 'usergeo', 'type' => 'string');

        $flds[] = array('name' => 'is_right_side_bar', 'type' => 'bool');

        return $flds;
    }

    public static function getUnserializeFlds(&$contentValues, $flds)
    {
        $fld_types = Contents::get_sys_fld_types();

        foreach ($flds as $fld) {
            foreach ($fld_types as $fld_type) {
                if ($fld['type'] == $fld_type['name']) {
                    if ($fld_type['serialized']) {

                        $contentValues['' . $fld['name']] = unserialize($contentValues['' . $fld['name']]);
                    }
                }
            }
        }
    }

    private static function get_field_datatype($fld_type_name)
    {

        $fld_types = Contents::get_sys_fld_types();

        foreach ($fld_types as $fld_type) {

            if ($fld_type_name == $fld_type['name']) {

                return $fld_type['sqltype'];
            }
        }
        return "text";
    }

    public static function get_sys_fld_type_names()
    {
        $fld_names = array();
        $fld_types = Contents::get_sys_fld_types();
        foreach ($fld_types as $fld_type) {
            $fld_names[$fld_type['name']] = $fld_type['hname'];
        }
        return $fld_names;
    }

    public static function get_sys_fld_types()
    {

        $fld_types = array();

        $fld_types[] = array("name" => "id", "hname" => "ID", "sqltype" => "char(36) NOT NULL", "serialized" => false);
        $fld_types[] = array("name" => "uuid", "hname" => "UUID", "sqltype" => "char(36)", "serialized" => false);
        $fld_types[] = array("name" => "bool", "hname" => "Boolean", "sqltype" => "bool", "serialized" => false);

        $fld_types[] = array("name" => "number_integer", "hname" => "Integer", "sqltype" => "int", "serialized" => false);
        $fld_types[] = array("name" => "number_long", "hname" => "Long", "sqltype" => "long", "serialized" => false);
        $fld_types[] = array("name" => "number_decimal", "hname" => "Decimal", "sqltype" => "decimal(14,4)", "serialized" => false);

        $fld_types[] = array("name" => "color", "hname" => "Color Box", "sqltype" => "varchar(15)", "serialized" => false);

        $fld_types[] = array("name" => "date", "hname" => "Date Box", "sqltype" => "date", "serialized" => false);
        $fld_types[] = array("name" => "datetime", "hname" => "Datetime Box", "sqltype" => "datetime", "serialized" => false);

        $fld_types[] = array("name" => "string", "hname" => "Plain Text", "sqltype" => "varchar(250)", "serialized" => false);
        $fld_types[] = array("name" => "text", "hname" => "Localize Text", "sqltype" => "text", "serialized" => false);
        $fld_types[] = array("name" => "htmltext", "hname" => "Localize Html Content", "sqltype" => "text", "serialized" => false);

        $fld_types[] = array("name" => "nodereference", "hname" => "Single Link", "sqltype" => "varchar(250)", "serialized" => true);
        $fld_types[] = array("name" => "linklist", "hname" => "Multiple Links", "sqltype" => "text", "serialized" => true);

        $fld_types[] = array("name" => "filefield", "hname" => "Single File", "sqltype" => "text", "serialized" => true);
        $fld_types[] = array("name" => "imglist", "hname" => "Multiple Files", "sqltype" => "text", "serialized" => true);

        $fld_types[] = array("name" => "contentref", "hname" => "Single Content Ref", "sqltype" => "varchar(250)", "serialized" => true);
        $fld_types[] = array("name" => "multicontentref", "hname" => "Multiple Content Ref", "sqltype" => "text", "serialized" => true);

        $fld_types[] = array("name" => "geocode", "hname" => "Geo-Location", "sqltype" => "text", "serialized" => true);

        $fld_types[] = array("name" => "email", "hname" => "Email", "sqltype" => "varchar(250)", "serialized" => false);
        $fld_types[] = array("name" => "emvideo", "hname" => "Embedded Video", "sqltype" => "varchar(250)", "serialized" => false);
        $fld_types[] = array("name" => "serialized", "hname" => "Serialized Content", "sqltype" => "text", "serialized" => true);
        // not decided yet

        $fld_types[] = array("name" => "lookuptbl", "hname" => "Texanomy", "sqltype" => "int", "serialized" => false);


        $fld_types[] = array("name" => "multitext", "hname" => "Multiple Localize Text", "sqltype" => "text", "serialized" => true);
        $fld_types[] = array("name" => "multihtmltext", "hname" => "Multiple Localize Html Content", "sqltype" => "text", "serialized" => true);
        $fld_types[] = array("name" => "multiselect", "hname" => "Multi Select Texanomy", "sqltype" => "varchar(200)", "serialized" => false);

        $fld_types[] = array("name" => "domainselector", "hname" => "Domain Selector", "sqltype" => "int", "serialized" => false);
        $fld_types[] = array("name" => "multidomainselector", "hname" => "Multi Domain Selector", "sqltype" => "text", "serialized" => true);

        $fld_types[] = array("name" => "childcontenttype", "hname" => "Child Content Type", "sqltype" => "char(1)", "serialized" => false);
        $fld_types[] = array("name" => "parentcontenttype", "hname" => "Parent Content Type", "sqltype" => "char(36)", "serialized" => false);

        $fld_types[] = array("name" => "contentefselect2", "hname" => "Dropdown", "sqltype" => "char(36)", "serialized" => false);
        $fld_types[] = array("name" => "dependentcontent", "hname" => "Dependent Select", "sqltype" => "char(36)", "serialized" => false);

        return $fld_types;
    }

}
