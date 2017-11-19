<?php

namespace Vokuro\CleanDomain;

use Phalcon\Mvc\User\Component;

include_once('/var/www/html/saas/dbconnect.php');

class CleanDomain extends Component {

    public static function cleanall_domain(){

        $con = mysql_connect("127.0.0.1", "root", "root");

        if (!$con) {
            die('Could not connect to MySQL server: ' . mysql_error());
        }
        $dbname = 'npfministryadmin';
        $db_selected = mysql_select_db($dbname, $con);
        if (!$db_selected) {
            die("Could not set $dbname: " . mysql_error());
        }
        CleanDomain::cleanall_menus();
        CleanDomain::cleanall_pageblocks();
        CleanDomain::cleanall_contents();
        CleanDomain::cleanall_resources();
    }

    public static function clean_domain($src_domain){
        $con = mysql_connect("127.0.0.1", "root", "root");
        if (!$con) {
            die('Could not connect to MySQL server: ' . mysql_error());
        }
        $dbname = 'npfministryadmin';
        $db_selected = mysql_select_db($dbname, $con);
        if (!$db_selected) {
            die("Could not set $dbname: " . mysql_error());
        }
        $did = CleanDomain::get_domain_id($src_domain);
        //echo $did;
        if($did){
            CleanDomain::clean_menus($did);
            CleanDomain::clean_pageblocks($did);
            CleanDomain::clean_contents($did);
            CleanDomain::clean_resources($src_domain);
        }
    }
    private static function cleanall_resources(){
        $root_dir = '/var/www/sites/default/files/files/';
        CleanDomain::rrmdir($root_dir);
    }
    private static function clean_resources($src_domain){
        $root_dir = '/var/www/sites/default/files/files/';
        $source = $root_dir.$src_domain;
        if (is_dir($source)) {
            CleanDomain::rrmdir($source);
        }
    }
    private static function run_query($query){
        return mysql_query($query);
    }

    private static function get_domain_id($domain_name){
        $query="SELECT id FROM npf_domains WHERE subdomain = '$domain_name'";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            return null;
        }

        while ($row = mysql_fetch_row($result)){
            //var_dump($row);
            return $row[0];
        }
        return null;
    }
    private static function cleanall_menus(){
        $query="DELETE FROM npfministryadmin.npf_menus WHERE 1=1";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            echo "Error Clean menus";
            return;
        }
    }
    private static function clean_menus($did){
        $query="DELETE FROM npfministryadmin.npf_menus WHERE domain_id = $did";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            echo "Error Clean menus";
            return;
        }
    }
    private static function cleanall_pageblocks(){
        $query="DELETE FROM npfministryadmin.npf_blocks WHERE 1=1";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            echo "Error Clean Pageblocks: " . mysql_error();
            return;
        }
    }
    private static function clean_pageblocks($did){
        $query="DELETE FROM npfministryadmin.npf_blocks WHERE domain_id = $did";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            echo "Error Clean Pageblocks: " . mysql_error();
            return;
        }
    }
    private static function cleanall_contents(){
        // get domain content type names
        $query="SELECT nct.id, nct.name FROM npfministryadmin.npf_content_types nct";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            echo "Error Clean Contents: " . mysql_error();
            return;
        }

        while ($row = mysql_fetch_row($result)){
            //var_dump($row);
            $tbl = $row[1];

            $query="DELETE FROM npfministryadmin.npf_content_$tbl WHERE 1=1";
            $rr=mysql_query($query);
            if(!$rr){
                echo "Error Clean Content-Type - $tbl: " . mysql_error();
                return;
            }
        }
    }
    private static function clean_contents($did){
        // get domain content type names
        $query="SELECT nct.id, nct.name FROM npfministryadmin.npf_content_types nct";
        //echo $query;
        $result=mysql_query($query);
        if(!$result){
            echo "Error Clean Contents: " . mysql_error();
            return;
        }

        while ($row = mysql_fetch_row($result)){
            //var_dump($row);
            $tbl = $row[1];

            $query="DELETE FROM npfministryadmin.npf_content_$tbl WHERE domain_id = $did";
            $rr=mysql_query($query);
            if(!$rr){
                echo "Error Clean Content-Type - $tbl: " . mysql_error();
                return;
            }
        }
    }

    private static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir")
                        CleanDomain::rrmdir($dir."/".$object);
                    else unlink   ($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

}