<?php

namespace Vokuro\CloneDomain;

use Phalcon\Mvc\User\Component;
use Vokuro\Uuid\Uuid;
use Vokuro\Models\DomainSetup;



class CloneDomain extends Component {
    public static function clone_domain($src_domain,$dest_domain){

        $con = mysql_connect("127.0.0.1", "root", "root");
        if (!$con) {
            die('Could not connect to MySQL server: ' . mysql_error());
        }
        $dbname = 'npfministryadmin';
        $db_selected = mysql_select_db($dbname, $con);
        if (!$db_selected) {
            die("Could not set $dbname: " . mysql_error());
        }
	 mysql_set_charset('utf8',$con);
        $src_did = CloneDomain::get_domain_id($src_domain);
        $clone_did = CloneDomain::get_domain_id($dest_domain);

        DomainSetup::copyDomainResources($clone_did[1],$clone_did[0]);

        if($src_did && $dest_domain){
            CloneDomain::clone_menus($src_did[0],$clone_did[0]);
            CloneDomain::clone_pageblocks($src_did[0],$clone_did[0]);
            //CloneDomain::clone_contents($src_did[0],$clone_did[0]);
            //CloneDomain::clone_resources($src_domain,$dest_domain);
        }
    }
    private static function clone_resources($src_domain,$dest_domain){
        $root_dir = '/var/www/sites/default/files/files/';
        $source = $root_dir.$src_domain;
        $dest = $root_dir.$dest_domain;
        CloneDomain::xcopy($source, $dest);
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
            //var_dump($row);
            return $row;
        }
        return null;
    }
    private static function clone_menus($old_did,$did){
        $query="SELECT * FROM npfministryadmin.npf_menus WHERE domain_id = $old_did";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            //die("Error Clone Menus: " . mysql_error());
            echo "Error Clune menus";
            return;
        }
        if(mysql_num_rows($result)<=0){
            //echo "No Result Found.";
            return;
        }
        $sql = CloneDomain::get_sql_statements('npf_menus', $result,$did);
        foreach($sql as $s){
            //echo $s;
            $r = CloneDomain::run_query($s);
            if(!$r){
                die("Error Clone Menus: " . mysql_error());
            }
        }
    }
    private static function clone_pageblocks($old_did,$did){
        $query="SELECT title_bn, title_en, body_bn, body_en, `more`, domain_id, weight,
                        region_id, template_block_name, created, lastmodified, createdby,
                        lastmodifiedby, uploadpath FROM npfministryadmin.npf_blocks
				WHERE domain_id=$old_did";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            die("Error Clone Pageblocks: " . mysql_error());
        }

        $sql = CloneDomain::get_sql_statements('npf_blocks', $result,$did);
        foreach($sql as $s){
            //echo $s;
            $r = CloneDomain::run_query($s);
            if(!$r){
                die("Error Clone Pageblocks: " . mysql_error());
            }
        }
    }
    private static function clone_contents($old_did,$did){
        // get domain content type names
        $query="SELECT nct.id, nct.name FROM npfministryadmin.npf_content_types nct
			INNER JOIN npf_domain_resources ndct ON  FIND_IN_SET(nct.id,ndct.content_type_ids)
			WHERE ndct.domain_id = $old_did
			";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            die("Error Clone Pageblocks: " . mysql_error());
        }

        while ($row = mysql_fetch_row($result)){
            //var_dump($row);
            $tbl = $row[1];

            $query="SELECT * FROM npf_content_$tbl WHERE domain_id = $old_did AND active=1 AND publish=1";
            $rr=mysql_query($query);

            $num_rows = mysql_num_rows($rr);
            if($num_rows<=0){
                continue;
            }
            //echo "Cloning $tbl -> rows found: $num_rows";
            $sql = CloneDomain::get_sql_statements('npf_content_'.$tbl, $rr,$did);
		//print_r($sql);exit;

            foreach($sql as $s){
			//echo "<pre>";
			//var_dump($s);

                $r = CloneDomain::run_query($s);
                if(!$r){
                    die("Error Clone Content Type - $tbl : " . mysql_error());
                }
            }
        }
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
//echo $new_ref . " " .$id;
            $query='UPDATE npf_menus SET link_path = "'.$new_ref.'" WHERE id = "'.$id.'"';
//var_dump($query);//die();

            $r = CloneDomain::run_query($query);
            if(!$r){
                die("Error Clone Content Type - $tbl : " . mysql_error());
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
    private static function xcopy($source, $dest, $permissions = 0755)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            CloneDomain::xcopy("$source/$entry", "$dest/$entry");
        }

        // Clean up
        $dir->close();
        return true;
    }

}