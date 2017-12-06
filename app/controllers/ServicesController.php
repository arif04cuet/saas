<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Models\Contents;


class ServicesController extends ControllerBase
{
    public function getservicesAction()
    {
        $this->view->disable();
/*
        $sql = "";
        $results = Contents::run_sql($sql);
*/
        $childs = array();
        if (($this->request->isPost())&&($this->request->isAjax() == true))
        {
            $lang = $this->request->getQuery("ln", "string");
            $domaintypeid = $this->request->getQuery("did", "int");
            $tmp = array();
            if($domaintypeid){
                //$tmp = NpfDomains::find("active=1 and domain_type_id=".$domaintypeid);
                $sql = "
                    SELECT
                        cs.id id,
                        cs.title_bn title,
                        cs.uploadpath,
                        cs.flow_chart
                        FROM
                        npfministryadmin.npf_content_service_portal cs
                        WHERE cs.service_domain = ".$domaintypeid." AND cs.active = 1 AND cs.publish = 1
                ";
                //echo $sql;
                $tmp = Contents::run_sql($sql);
                //var_dump($tmp);exit;
            }
            foreach($tmp as $t){
                if($lang=='bn'){

                    /////////////////////start of flow chart image show///////////////////
                    $filefield = $t->flow_chart;
                    /*
                    if(is_serialized( $filefield )){
                        $filefield = unserialize( $filefield );
                    }
                    if(!isset($filefield['name'])){
                        $filefield = $filefield[0];
                    }
                    if(!empty($filefield['name'])){
                        //$f_path = '/sites/default/files/files/services.portal.gov.bd/service_portal/'.$uploadpath.'/'.$filefield['name'];
                        $f_path = $filefield['name'];
                        $uploadpath = str_replace("-", '_', $t->uploadpath);
                    }
                    else
                    {
                        $f_path = "";
                        $uploadpath = "";
                    }
                    */
                    $f_path = $filefield['name'];
                    $uploadpath = str_replace("-", '_', $t->uploadpath);
                    /////////////////////end of flow chart image show///////////////////

                    $childs[] = array('did'=>$t->id,'name'=>$t->title,'fchart'=>$f_path,'upath'=>$uploadpath);
                }
            }
        }
//        var_dump($childs);
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }

    public function getservicesminAction()
    {
        $this->view->disable();
        /*
                $sql = "";
                $results = Contents::run_sql($sql);
        */
        $childs = array();
        if (($this->request->isPost())&&($this->request->isAjax() == true))
        {
            $lang = $this->request->getQuery("ln", "string");
            $domaintypeid = $this->request->getQuery("did", "int");
            $tmp = array();
            if($domaintypeid){
                //$tmp = NpfDomains::find("active=1 and domain_type_id=".$domaintypeid);
                $sql = "SELECT
                cs.id id,
                cs.title_bn title,
                cs.service_domain,
                cs.uploadpath,
                cs.flow_chart,
                sdm.sitename_bn
                FROM
                npfministryadmin.npf_content_service_portal cs
                left join npfministryadmin.npf_domains sdm on cs.service_domain = sdm.id
                WHERE cs.active = 1 AND cs.publish = 1 and
                (cs.service_domain in(SELECT dm.id FROM npfministryadmin.npf_domains dm WHERE dm.parent_id=".$domaintypeid."
                and dm.active=1) or cs.service_domain='".$domaintypeid."')";

                //echo $sql;
                $tmp = Contents::run_sql($sql);
                //var_dump($tmp);exit;
            }
            foreach($tmp as $t){
                if($lang=='bn'){

                    /////////////////////start of flow chart image show///////////////////
                    $filefield = $t->flow_chart;
                    /*
                    if(is_serialized( $filefield )){
                        $filefield = unserialize( $filefield );
                    }
                    if(!isset($filefield['name'])){
                        $filefield = $filefield[0];
                    }
                    if(!empty($filefield['name'])){
                        //$f_path = '/sites/default/files/files/services.portal.gov.bd/service_portal/'.$uploadpath.'/'.$filefield['name'];
                        $f_path = $filefield['name'];
                        $uploadpath = str_replace("-", '_', $t->uploadpath);
                    }
                    else
                    {
                        $f_path = "";
                        $uploadpath = "";
                    }
                    */
                    $f_path = $filefield['name'];
                    $uploadpath = str_replace("-", '_', $t->uploadpath);
                    /////////////////////end of flow chart image show///////////////////

                    $childs[] = array('did'=>$t->id,'name'=>$t->title,'dname'=>$t->sitename_bn,'domid'=>$t->service_domain, 'fchart'=>$f_path,'upath'=>$uploadpath);
                }
            }
        }
//        var_dump($childs);
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }

    public function getdomainidsAction(){
        $this->view->disable();
        $childs = array();
        if (($this->request->isPost())&&($this->request->isAjax() == true))
        {
            $lang = $this->request->getQuery("ln", "string");
            $domaintypeid = $this->request->getQuery("dtid", "int");
            $tmp = array();
            if($domaintypeid){
                $tmp = NpfDomains::find("active=1 and domain_type_id=".$domaintypeid);
            }else{

                $did = $this->request->getQuery("did", "int");
//                $parent = NpfDomains::findFirst("id='".$did."'");

                if($did){
                    $tmp = NpfDomains::find("active=1 and parent_id=".$did);
                }
            }
            foreach($tmp as $t){
                if($lang=='bn'){
                    $childs[] = array('did'=>$t->id,'name'=>$t->sitename_bn);
                }else if($lang=='en'){
                    $childs[] = array('did'=>$t->id,'name'=>$t->sitename_en);
                }

            }
        }
//        var_dump($childs);

        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }


    public function getdomain_dir_idsAction(){
        $this->view->disable();
        $childs = array();
        if (($this->request->isPost())&&($this->request->isAjax() == true))
        {
            $lang = $this->request->getQuery("ln", "string");
            $domain_id = $this->request->getQuery("did", "int");
            $tmp = array();
            if($domain_id){
                $sql = "SELECT distinct(s.service_domain) id, d.sitename_bn sitename_bn
                    FROM npfministryadmin.npf_content_service_portal as s
                    left join npfministryadmin.npf_domains as d  on s.service_domain=d.id
                    WHERE s.active=1 and s.publish=1 and d.active=1 and d.parent_id='".$domain_id."'";
                //echo $sql;
                $tmp = Contents::run_sql($sql);
                //var_dump($tmp);exit;
            }

            foreach($tmp as $t){
                if($lang=='bn'){
                    $childs[] = array('did'=>$t->id,'name'=>$t->sitename_bn);
                }else if($lang=='en'){
                    $childs[] = array('did'=>$t->id,'name'=>$t->sitename_en);
                }

            }
        }
//        var_dump($childs);

        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }

    public function getedirAction()
    {
        $this->view->disable();
        /*
                $sql = "";
                $results = Contents::run_sql($sql);
        */
        $childs = array();
        if (($this->request->isPost())&&($this->request->isAjax() == true))
        {
            $lang = $this->request->getQuery("ln", "string");
            $domaintypeid = $this->request->getQuery("did", "int");
            $tmp = array();
            if($domaintypeid){
                //$tmp = NpfDomains::find("active=1 and domain_type_id=".$domaintypeid);
                $sql = "SELECT id id,
                title_bn title,
                field_designation_bn des,
                field_mobile_bn mobile,
                field_telephone_bn tel,
                field_email email
                FROM npfministryadmin.npf_content_e_directory
                WHERE
                domain_id='".$domaintypeid."' and active=1 and publish=1";
                //echo $sql;
                $tmp = Contents::run_sql($sql);
                //var_dump($tmp);exit;
            }

            foreach($tmp as $t){
                if($lang=='bn'){
                    $childs[] = array('eid'=>$t->id,'name'=>$t->title,'des'=>$t->des,'mobile_no'=>$t->mobile,'tel'=>$t->tel,'email_add'=>$t->email);
                }
            }
        }
//        var_dump($childs);
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }

    public function getedirsearchAction()
    {
        $this->view->disable();
        /*
                $sql = "";
                $results = Contents::run_sql($sql);
        */
        $childs = array();
        if (($this->request->isPost())&&($this->request->isAjax() == true))
        {
            //$lang = $this->request->getQuery("ln", "string");
            $src_name = $this->request->getQuery("src_name", "string");
            $src_des = $this->request->getQuery("src_des", "string");
            $src_mobile = $this->request->getQuery("src_mobile", "string");
            $tmp = array();

            $where_clause = "";
            $where_arr = array();
            if($src_name!="")
            {
                $where_arr[] = "title_bn like '%$src_name%'";
            }
            if($src_des!="")
            {
                $where_arr[] = "field_designation_bn like '%$src_des%'";
            }
            if($src_mobile!="")
            {
                $where_arr[] = "field_mobile_bn like '%$src_mobile%'";
            }

            if(count($where_arr)>0)
            {
                $where_clause = implode(' and ', $where_arr);
                $where_clause .=  " and active=1 and publish=1 ";
            }
            else
            {
                $where_clause = " active=1 and publish=1 ";
            }

            //$tmp = NpfDomains::find("active=1 and domain_type_id=".$domaintypeid);
            $sql = "SELECT id id,
            title_bn title,
            field_designation_bn des,
            field_mobile_bn mobile,
            field_telephone_bn tel,
            field_email email
            FROM npfministryadmin.npf_content_e_directory
            WHERE ".$where_clause;
            //echo $sql; exit;
            $tmp = Contents::run_sql($sql);
            //var_dump($tmp);exit;

            foreach($tmp as $t){
                    $childs[] = array('eid'=>$t->id,'name'=>$t->title,'des'=>$t->des,'mobile_no'=>$t->mobile,'tel'=>$t->tel,'email_add'=>$t->email);
            }
        }
        //var_dump($childs);
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }

    public function getdetailsrightAction()
    {
        $this->view->disable();

        $s_id = $this->request->getQuery("id", "string");
        $out_html = "";
        //////////////////////////////////////////////////////
        $sql = "SELECT  s.id id, d.sitename_bn dir_name, d.id dir_id FROM npfministryadmin.npf_content_service_portal as s
left join npfministryadmin.npf_domains as d  on s.service_domain=d.id
WHERE s.id='".$s_id."' and s.active=1 and s.publish=1";
        //echo $sql; exit;
        $tmp = Contents::run_sql($sql);

        //var_dump($tmp);exit;
        foreach($tmp as $t){
            $service_sql = "
                    SELECT
                        cs.id cs_id,
                        cs.title_bn cs_title
                        FROM
                        npfministryadmin.npf_content_service_portal cs
                        WHERE cs.service_domain = ".$t->dir_id." AND cs.active = 1 AND cs.publish = 1 and cs.id<>'".$t->id."' limit 0,3";

           //echo $service_sql;exit;
            $service_tmp = Contents::run_sql($service_sql);
			
			if($t->dir_id == 6487)
			{
				$t->dir_name = "উপজেলা ভুমি অফিস";
			}
			else if($t->dir_id == 5598)
			{ 
				$t->dir_name = "ইউ এন ও অফিস";
			}
			
            ////////////////////////////////////////
            $out_html .= '<h3 class="bk-org title">'.$t->dir_name.'<a style="float:right;" href="#" onclick="$(this).parent().next().slideToggle(500); $(this).children().toggle(); return false;">';
                    $out_html .= '<i class="flaticon-plus55" style="display: none; font-size: 22px ! important; margin: 5px;" ></i>';
                    $out_html .= '<i style="display: inline; font-size: 22px ! important; margin: 5px;" class="flaticon-minus53"></i>';
                $out_html .= '</a>';
            $out_html .= '</h3>';
            $out_html .= '<ul>';
                foreach($service_tmp as $ser_t){
                    //--------tappware
                    $new_title = str_replace(" ","-",$ser_t->cs_title);
                    $new_title = htmlspecialchars($new_title, ENT_QUOTES);
                    //--------tappware
                    $out_html .= '<li><a href="/site/service_portal/'.$ser_t->cs_id.'/'.$new_title.'"><i class="flaticon-circle90 green"></i>&nbsp;'.$ser_t->cs_title.'</a></li>';
                }
            //--------tappware
            $new_name = str_replace(" ","-",$t->dir_name);
            $new_name = htmlspecialchars($new_name, ENT_QUOTES);
            //--------tappware
            $out_html .= '<li style="text-align: right;"><a href="/site/view/services_org/'.$t->dir_id.'/'.$new_name.'">আরও...</a></li>';
            $out_html .= '</ul>';
            /////////////////////////////////////////
            /*
            $out_html .= '<a href="/site/view/org_services?t='.$t->dir_id.'&m='.$t->dir_name.'" class="service_cat_btn">'.$t->dir_name.'</a>';
            $out_html .= '<ul style="margin:0" class="caption fade-caption">';

            foreach($service_tmp as $ser_t){
                $out_html .= '<li><a href="/site/service_portal/'.$ser_t->cs_id.'">'.$ser_t->cs_title.'</a></li>';
            }
            $out_html .= '<li style="float: right;margin-top: 10px;list-style: none;margin-right: 10px;"><a href="/site/view/org_services?t='.$t->dir_id.'&m='.$t->dir_name.'">আরও...</a></li>';
            $out_html .= '</ul>';
            */
            break;

        }

        echo $out_html;
    }

    public function getdetailsrightprAction()
    {
        $this->view->disable();

        $s_id = $this->request->getQuery("id", "string");
        $out_html = "";
        //////////////////////////////////////////////////////
        $sql = "SELECT  s.id id, lt.id catid,lt.name_bn catname FROM npfministryadmin.npf_content_service_portal as s
left join npfministryadmin.npf_lookups as lt  on s.service_pr_cat=lt.id
WHERE s.id='".$s_id."' and s.active=1 and s.publish=1";
        //echo $sql;
        $tmp = Contents::run_sql($sql);
        //var_dump($tmp);exit;
        foreach($tmp as $t){
            $service_sql = "
                    SELECT
                        cs.id cs_id,
                        cs.title_bn cs_title
                        FROM
                        npfministryadmin.npf_content_service_portal cs
                        WHERE cs.service_pr_cat = ".$t->catid." AND cs.active = 1 AND cs.publish = 1 and cs.id<>'".$t->id."' limit 0,3";
            $service_tmp = Contents::run_sql($service_sql);

            ////////////////////////////////////////
            $out_html .= '<h3 class="bk-org title">'.$t->catname.'<a style="float:right" href="/site/view/services_pcat?t='.$t->catid.'&m='.$t->catname.'" onclick="$(this).parent().next().slideToggle(500); $(this).children().toggle(); return false;">';
            $out_html .= '<i class="flaticon-plus55" style="display: none; font-size: 22px ! important; margin: 5px;" ></i>';
            $out_html .= '<i style="display: inline; font-size: 22px ! important; margin: 5px;" class="flaticon-minus53"></i>';
            $out_html .= '</a>';
            $out_html .= '</h3>';
            $out_html .= '<ul>';
            foreach($service_tmp as $ser_t){
                    //--------tappware
                    $new_title = str_replace(" ","-",$ser_t->cs_title);
                    $new_title = htmlspecialchars($new_title, ENT_QUOTES);
                    //--------tappware
                $out_html .= '<li><a href="/site/service_portal/'.$ser_t->cs_id.'/'.$new_title.'"><i class="flaticon-circle90 green"></i>&nbsp;'.$ser_t->cs_title.'</a></li>';
            }
            //--------tappware
            $new_name = str_replace(" ","-",$t->catname);
            $new_name = htmlspecialchars($new_name, ENT_QUOTES);
            //--------tappware
            $out_html .= '<li style="text-align: right;"><a href="/site/view/services_pcat/'.$t->catid.'/'.$new_name.'">আরও...</a></li>';
            $out_html .= '</ul>';
            /////////////////////////////////////////
            /*
            $out_html .= '<a href="" class="service_cat_btn">'.$t->catname.'</a>';
            $out_html .= '<ul style="margin:0" class="caption fade-caption">';

            foreach($service_tmp as $ser_t){
                $out_html .= '<li><a href="/site/service_portal/'.$ser_t->cs_id.'">'.$ser_t->cs_title.'</a></li>';
            }
            $out_html .= '<li style="float: right;margin-top: 10px;list-style: none;margin-right: 10px;"><a href="/site/view/services_pc?t='.$t->catid.'&m='.$t->catname.'">আরও...</a></li>';
            $out_html .= '</ul>';
            */
            break;
        }
        echo $out_html;
    }

///////==============================================/////////
///////=================version - 2==================/////////
///////==============================================/////////
    public function get_s_contentAction(){
        $this->view->disable();

        $cat_type = $this->request->getQuery("type", "string");

        $html = '';
        $html .= '<ul>';
        //////////////////////////////////////////////////////
        if($cat_type=="cat")
        {
            $sql = 'SELECT
				lt.id catid,
				lt.name_bn catname,
				cs.id id,
				cs.title_bn title
				FROM
				npfministryadmin.npf_lookups lt
				CROSS JOIN
				npfministryadmin.npf_content_service_portal cs
				ON FIND_IN_SET(lt.id, cs.sel_category)
				WHERE cs.active = 1 AND cs.publish = 1 order by lt.weight, TRIM(catname)
				';
        }
        else if($cat_type=="pcat")
        {
            $sql = '
                SELECT
                    lt.id catid,
                    lt.name_bn catname,
                    cs.id id,
                    cs.title_bn title
                    FROM
                    npfministryadmin.npf_lookups lt
                    CROSS JOIN
                    npfministryadmin.npf_content_service_portal cs
                    ON FIND_IN_SET(lt.id, cs.service_pr_cat)
                    WHERE cs.active = 1 AND cs.publish = 1 order by lt.weight, TRIM(catname)
            ';
        }
        else if($cat_type=="off")
        {
            $sql = '
                SELECT
                    lt.id catid,
                    lt.name_bn catname,
                    cs.id id,
                    cs.title_bn title
                    FROM
                    npfministryadmin.npf_lookups lt
                    CROSS JOIN
                    npfministryadmin.npf_content_service_portal cs
                    ON FIND_IN_SET(lt.id, cs.dis_up_off)
                    WHERE  cs.active = 1 AND cs.publish = 1 order by lt.weight, TRIM(catname) 
            ';
        }
        else if($cat_type=="org")
        {

            $sql = "SELECT cs.title_bn title, cs.id id, d.id catid, d.sitename_bn catname
            FROM npfministryadmin.npf_content_service_portal cs
            left join npfministryadmin.npf_domains d on cs.service_domain= d.id
            where cs.active = 1 AND cs.publish = 1 and d.id<>''";
        }

        //echo $sql;exit;

        $result = Contents::run_sql($sql);
        $a_result = array();
        $flg = false;
        //var_dump($result);exit;

        //while($row = db_fetch_object($result))
        foreach($result as $row)
        {
            $flg = true;
            $a_result[] = get_object_vars($row);
        }

        ///////////////////////////////////////////
        //var_dump($a_result);exit;
        $content_body = '';
        if($flg){
            $t_result = $this->makeArrayGroup(array('catname'), $a_result);
            //var_dump($t_result);exit;
            $i = 1;
            foreach($t_result as $slnks)
            {
                //var_dump($slnks[0]);
                $content_body .= '<li>';
                $content_body .= '<div>';
                $content_body .= '<i class="flaticon-circle46 green"></i>';

                //--------tappware
                $new_title = str_replace(" ","-",$slnks[0]['catname']);
                $new_title = htmlspecialchars($new_title, ENT_QUOTES);
                //--------tappware

                //$content_body .= '<a href="/site/view/services_'.$cat_type.'?t='.$slnks[0]['catid'].'&m='.$slnks[0]['catname'].'">'.$slnks[0]['catname'].'<span style="font-family: nikoshBan,arial;">('.sizeof($slnks).')</span></a>';
                $content_body .= '<a href="/site/view/services_'.$cat_type.'/'.$slnks[0]['catid'].'/'.$new_title.'">'.$slnks[0]['catname'].' <span style="font-family: nikoshBan;"> ('.sizeof($slnks).') </span></a>';
				
				/*
                if($i==1)
                {
                    $content_body .= '<a class="see-all" href="javascript:;" onclick="back_tab_show(this,\''.$i.'\');">সব দেখুন<i class="flaticon-arrow555"></i></a>';
                    //$content_body .= '<a style="background-color:'.$c_arr[$r_keys[$key]].' !important;" class="service_cat_btn" href="/site/view/services_pc?t='.$slnks[0]['catid'].'&m='.$slnks[0]['catname'].'">'.$slnks[0]['catname'].' &nbsp;('.sizeof($slnks).')</a>';
                    $content_body .= '<div class="office-content" id="office-content-'.$i.'" style="">';
                    $content_body .= '<ul class="office-content-ul">';
                }
                else
                {
				*/
                    $content_body .= '<a class="see-all" href="javascript:;" onclick="back_tab_show(this,\''.$i.'\');">সব দেখুন<i class="flaticon-arrow483"></i></a>';
                    //$content_body .= '<a style="background-color:'.$c_arr[$r_keys[$key]].' !important;" class="service_cat_btn" href="/site/view/services_pc?t='.$slnks[0]['catid'].'&m='.$slnks[0]['catname'].'">'.$slnks[0]['catname'].' &nbsp;('.sizeof($slnks).')</a>';
                    $content_body .= '<div class="office-content" id="office-content-'.$i.'" style="display: none;">';
                    $content_body .= '<ul class="office-content-ul">';
                /*
				}
				*/
				
                foreach($slnks as $lnk){
                    //$content_body .= '<li><a href="/site/service_portal/'.$lnk['id'].'">'.$lnk['title'].'</a></li>';
                    ///////////////////////////////////////////////////////////////////
                    $content_body .= '<li class="office-content-ul-li">';
                        $content_body .= '<div class="office-content-title float-left">';
						/*================= tt SEO===================*/
						//$content_body .= '<i class="flaticon-right65"></i><a href="/site/service_portal/'.$lnk['id'].'">'.$lnk['title'].'</a>';
                        $content_body .= '<i class="flaticon-right65"></i><a href="/site/service_portal/'.$lnk['id'].'/'.$lnk['title'].'">'.$lnk['title'].'</a>';
                    $content_body .= '</div>';
                    $content_body .= '<div class="office-content-right float-right">';
                    /*
                    $content_body .= '<i class="flaticon-email26"></i>';
                    $content_body .= '<i class="flaticon-rss11"></i>';
                    $content_body .= '<i class="flaticon-menu10"></i>';

                    $content_body .= '<i class="flaticon-newspapre"></i>';
                    $content_body .= '<i class="flaticon-order"></i>';
                    $content_body .= '<i class="flaticon-press4"></i>';
                    */

                    $content_body .= '</div>';
                    $content_body .= '</li>';
                    ///////////////////////////////////////////////////////////////////
                }

                $content_body .= '</ul>';
                $content_body .= '</div>';
                $content_body .= '</div>';
                $content_body .= '</li>';

                $i++;
            }
        }
        //////////
        $html .=  $content_body;
        $html .= '</ul>';

        echo $html;
    }


    function makeArrayGroup($group, $data){

        $group_size = sizeof($group);
        $result = null;
        foreach($data as $dt){
            $tmp1 = array();
            for( $st = $group_size - 1 ; $st>=0 ; $st-- ){
                $tmp2 = array();
                $key_val = $dt[$group[$st]];
                $tmp2[$key_val] = $tmp1;
                $tmp1 = $tmp2;
            }
            if($result==null){
                $result = $tmp1;
            }else{
                $result = array_merge_recursive($result, $tmp1);
            }
        }
        $this->makeArrayGroupDFS($group[$group_size-1],$data, $result);
        return $result;
    }
    function makeArrayGroupDFS($f,$data, &$tmp) {
        foreach($tmp as $key=>&$val){
            if(is_array($val) && (sizeof($val)>0)){
                $this->makeArrayGroupDFS($f,$data,$val);
            }else{
                $tmp_key = $this->makeArrayGroupSearch($data,$f,$key);
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
                $results = array_merge($results, $this->makeArrayGroupSearch($subarray, $key, $value));
            }
        }
        return $results;
    }

///////==============================================/////////
///////=================version - 2==================/////////
///////==============================================/////////



///////==============================================/////////
///////=================forms portal online application==================/////////
///////==============================================/////////

public function getministrylistAction()
    {
        $this->view->disable();
		
		$out_html="";
        //$s_id = $this->request->getQuery("id", "string");
        $out_html = "<option value=''>--বাছাই করুন--</option>";
        //////////////////////////////////////////////////////
        $sql = "SELECT name_bng,id FROM npfministryadmin.office_ministries WHERE active_status=1";
       //echo $sql;
        $tmp = Contents::run_sql($sql);
        //var_dump($tmp);exit;
        foreach($tmp as $t){
			$out_html .= "<option value=".$t->id.">".$t->name_bng."</option>";			
		}
		
        echo $out_html;
    }
	
public function getofficelayerlistAction()
    {
        $this->view->disable();
		
		$m_id = $this->request->getQuery("id", "string");
		
		$out_html="";
        //$s_id = $this->request->getQuery("id", "string");
        $out_html = "<option value=''>--বাছাই করুন--</option>";
        //////////////////////////////////////////////////////
        $sql = "SELECT layer_name_bng,id FROM npfministryadmin.office_layers WHERE office_ministry_id='".$m_id."' and active_status=1";
       //echo $sql;
        $tmp = Contents::run_sql($sql);
        //var_dump($tmp);exit;
        foreach($tmp as $t){
			$out_html .= "<option value=".$t->id.">".$t->layer_name_bng."</option>";			
		}
		
        echo $out_html;
    }

public function getofficeoriginlistAction()
    {
        $this->view->disable();
		
		$l_id = $this->request->getQuery("id", "string");
		
		$out_html="";
        //$s_id = $this->request->getQuery("id", "string");
        $out_html = "<option value=''>--বাছাই করুন--</option>";
        //////////////////////////////////////////////////////
        $sql = "SELECT office_name_bng,id FROM npfministryadmin.office_origins WHERE office_layer_id='".$l_id."' and active_status=1";
       //echo $sql;
        $tmp = Contents::run_sql($sql);
        //var_dump($tmp);exit;
        foreach($tmp as $t){
			$out_html .= "<option value=".$t->id.">".$t->office_name_bng."</option>";			
		}
		
        echo $out_html;
    }
	
public function getofficelistAction()
    {
        $this->view->disable();
		
		$o_id = $this->request->getQuery("id", "string");
		
		$out_html="";
        //$s_id = $this->request->getQuery("id", "string");
        $out_html = "<option value=''>--বাছাই করুন--</option>";
        //////////////////////////////////////////////////////
        $sql = "SELECT office_email,office_name_bng FROM npfministryadmin.offices WHERE office_origin_id='".$o_id."' and active_status=1";
       //echo $sql;
        $tmp = Contents::run_sql($sql);
        //var_dump($tmp);exit;
        foreach($tmp as $t){
			$out_html .= "<option value=".$t->office_email.">".$t->office_name_bng."</option>";			
		}
		
        echo $out_html;
    }

public function sendapplicationAction()
    {
        $this->view->disable();
		
		$email = $this->request->getQuery("sender-office-id", "string");
		
			$admin_email = "hafijurcse@gmail.com";
		  //$email = $_REQUEST['email'];
		  $subject = "test test test";
		  $comment = "comment";
		  
		  //send email
		  mail($admin_email, "$subject", $comment, "From:" . $email);
		  
		  
    }
				
///////==============================================/////////
///////=================forms portal online application==================/////////
///////==============================================/////////
	

}