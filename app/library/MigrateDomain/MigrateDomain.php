<?php

namespace Vokuro\MigrateDomain;

use Phalcon\Mvc\User\Component;
use Vokuro\Uuid\Uuid;
use Vokuro\Models\DomainSetup;

class MigrateDomain extends Component {

    public static function migrate_domain($src_domain, $src_db){
        // connect with db
        $con = mysql_connect('localhost', 'root', '_007_r00t_');
        if (!$con) {
            die('Could not connect to MySQL server: ' . mysql_error());
        }
        $dbname = 'npfministryadmin';
        $db_selected = mysql_select_db($dbname, $con);
        if (!$db_selected) {
            die("Could not set $dbname: " . mysql_error());
        }

        mysql_set_charset('utf8',$con);

        // get domain id
        $src_did = MigrateDomain::get_domain_id($src_domain);
        $did = $src_did[0];
        $tmp = MigrateDomain::migrate_menus($con, $did, $src_db);
        if(!$tmp){
            return $tmp;
        }
        // delete all contents before update by src_domain id
        $tmp = MigrateDomain::migrate_contents($con, $did, $src_db);
        if(!$tmp){
            return $tmp;
        }
        // copy all contents by src_domain id
        return true;
    }
    public static function migrate_menus($con, $did, $src_db){
        // delete all menu before update by src_domain id
        $query="DELETE FROM npf_menus WHERE domain_id = $did";
//        echo $query;
        $result=mysql_query($query);
        if(!$result){
            //die("Error Clone Menus: " . mysql_error());
            echo "Error deleting menus";
            return false;
        }
        // copy menu by src_domain id
        $query="INSERT INTO npfministryadmin.npf_menus
                    SELECT t.*
                    FROM {$src_db}.npf_menus t
                    WHERE t.domain_id = {$did}";
//        echo $query;
        $result=mysql_query($query);
        if(!$result){
            //die("Error Clone Menus: " . mysql_error());
            echo "Error Inserting menus";
            return false;
        }
        return true;
    }

    public static function migrate_contents($con, $did, $src_db){

        $query="SELECT nct.id, nct.name FROM npfministryadmin.npf_content_types nct
			INNER JOIN npf_domain_resources ndct ON  FIND_IN_SET(nct.id,ndct.content_type_ids)
			WHERE ndct.domain_id = $did
			";
//        echo $query;
        $result1 =mysql_query($query);
        if(!$result1){
            echo "Error fetching Content Types Info: " . mysql_error();
            return false;
        }
//        var_dump($result1);
        while ($row = mysql_fetch_row($result1)){
//            var_dump($row);
            $tbl = $row[1];
            // delete all menu before update by src_domain id
            $query="DELETE FROM npf_content_{$tbl} WHERE domain_id = $did";
//            echo $query;

            $result=mysql_query($query);
            if(!$result){
                //die("Error Clone Menus: " . mysql_error());
                echo "Error Deleting Content Type: ".$tbl;
                return false;
            }
            $query="DELETE FROM npf_content_{$tbl}_version WHERE domain_id = $did";

//            echo $query;
            $result=mysql_query($query);
            if(!$result){
                //die("Error Clone Menus: " . mysql_error());
                echo "Error Deleting Content Type: ".$tbl;
                return false;
            }
            // copy all
//
            $query="INSERT INTO npfministryadmin.npf_content_{$tbl}
                    SELECT t.*
                    FROM {$src_db}.npf_content_{$tbl} t
                    WHERE t.domain_id = {$did}";
//            echo $query;
            $result=mysql_query($query);
            if(!$result){
                //die("Error Clone Menus: " . mysql_error());
                echo "Error Inserting Content Type: ".$tbl;
                return false;
            }
            // copy all version
            $query="INSERT INTO npfministryadmin.npf_content_{$tbl}_version
                    SELECT t.*
                    FROM {$src_db}.npf_content_{$tbl}_version t
                    WHERE  t.domain_id = {$did}";
//        echo $query;
            $result=mysql_query($query);
            if(!$result){
                //die("Error Clone Menus: " . mysql_error());
                echo "Error Inserting Content Type: ".$tbl;
                return false;
            }
        }
        return true;
    }


    private static function run_query($query){
        return mysql_query($query);
    }

    private static function get_domain_id($domain_name){
        $query="SELECT id, domain_type_id FROM npf_domains WHERE subdomain = '$domain_name'";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            return null;
        }

        while ($row = mysql_fetch_row($result)){
//            var_dump($row);
            return $row;
        }
        return null;
    }

    private static function get_sql_statements($tbl_name, $result,$did){
        $sql = array();
        $col_names = CloneDomain::get_col_array($result);
        while ($row = mysql_fetch_row($result)){
            $sql[] = CloneDomain::gen_insert_statement($tbl_name, $col_names, $row,$did);
        }
        return $sql;
    }
    private static function get_col_array($result){
        $cols = array();
        $numfields = mysql_num_fields($result);
        for ($i=0; $i < $numfields; $i++){
            $con_name = mysql_field_name($result, $i);
            $cols[$i] = $con_name;
        }
        return $cols;
    }

    private static function gen_insert_statement($tbl_name, $col_names, $row,$did){
        $col_values = array();
        $numfields = sizeof($col_names);
        $org_id = '';
        $cln_id = '';

        for($i=0; $i < $numfields; $i++){
            $col_values[$i] =  CloneDomain::get_field_value($col_names[$i],$row[$i],$did);
            if($col_names[$i]=='id'){
                $org_id = $row[$i];
                $cln_id = $col_values[$i];
            }
        }
        $cntn_name = str_replace("npf_content_", "", $tbl_name);
        CloneDomain::update_menu_for_content( '/site/'.$cntn_name.'/'.$org_id, '/site/'.$cntn_name.'/'.$cln_id, $did);

        $flds = implode(",", $col_names);
        $vals = implode(",", $col_values);
        $sql = 'INSERT INTO npfministryadmin.'.$tbl_name.'('.$flds.')VALUES('.$vals.')';

        return $sql;
    }
    private static function update_menu_for_content($ref,$new_ref,$did){
        $query="SELECT id FROM  npf_menus WHERE link_path = '$ref' AND domain_id = $did";

        $result=mysql_query($query);
        if(!$result){
            die("Error Clone Pageblocks: " . mysql_error());
        }

        while ($row = mysql_fetch_row($result)){
            $id = $row[0];
            $query="UPDATE npf_menus SET link_path = '$new_ref' WHERE id = '$id';";

            $r = CloneDomain::run_query($query);
            if(!$r){
                die("Error Clone Menus : " . mysql_error());
            }
        }
    }
    private static function get_field_value($col_name,$col_val,$did){
        switch($col_name){
            case "id" : return "'".Uuid::v4()."'";
            case "version": return 0;
            case "lastmodified": return 'NOW()';
            case "created": return 'NOW()';
            case "createdby":
            case "lastmodifiedby": return 17;
            case "domain_id": return $did;
            case "menu_link_type_id": return '(NULL)';
        }

        if(trim($col_val)==''){
            return "(NULL)";
        }
        return "'".addslashes($col_val)."'";
    }


}