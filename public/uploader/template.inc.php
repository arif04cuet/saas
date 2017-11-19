<?php
global $domain_info;
global $theme_path;
function init_template(&$vars){

    global $is_right_side_bar;
    global $domain_info;
    global $language;
    global $print_btn;
    

    $print_btn = false;


    $vars['print_btn'] = false;
 
    $vars['domain_meta'] = getDomainMeta();
    $vars['domain_title'] = getDomainTitle();
    $vars['domain_styles'] = getDomainStyleSheet();

    $vars['header_top'] = getHeaderTop();
    $vars['header_left'] = getHeaderLeft();
    $vars['header_right'] = getHeaderRight();

    $vars['scroll_banner'] = getScrollingBannerContent();

    ////////////////////////////////////////
    $vars['nav'] = getNavigation();
    $vars['s_content_pcat'] = getSContentPcat();
    $vars['f_content_cat'] = getFContentCat();
    $vars['f_content_off'] = getFContentOff();
    $vars['headerMetaContents']= headerMetaContents();
    $vars['breadcrumb'] = breadcrumb();
    $vars['hitcounter'] = hitcounter();


    /*
     $vars['services_body'] = getServicesContent();
    */
    ////////////////////////////////////////

    $vars['advertisement'] = getAdvertisement();
    $vars['rightMenu'] = getRightMenu();
    $vars['footerTopContent'] = getfooterTopContent();

    $vars['footerBoxFirst'] = footerBoxFirst();
    $vars['footerBoxSecond'] = footerBoxSecond();
	
    $vars['right'] = buildRegion($domain_info,$lang,'right');
}

function buildRegion($domainid,$lang,$region){
    $regionid = getRegionId($region);
    $html = get_all_block_by_region($regionid);
    return $html;
}

function getDomainTitle(){
    $title = '';
    $title .= "<title>Bangladesh Government Services Portal</title>";

    return $title;
}

function getDomainMeta(){
    $meta_data = "";

    $meta_data .= "<meta charset='utf-8'/>";
    $meta_data .= "<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>";
    $meta_data .= "<meta content='Responsive Theme for Bangladesh Government Service Portal' name='description'/>";
    $meta_data .= "<meta content='Bangladesh, Government, Service, Portal' name='keywords'/>";
    $meta_data .= "<meta content='a2i' name='author'/>";
    $meta_data .= "<meta content='Responsive Theme for Bangladesh Government Service Portal' property='og:title'/>";
    $meta_data .= "<meta content='website' property='og:type'/>";
    $meta_data .= "<meta content='Responsive Theme for Bangladesh Government Service Portal' property='og:description'/>";
    $meta_data .= "<meta content='http://service.portal.gov.bd/' property='og:url'/>";
    $meta_data .= "<meta content='http://cabinet.portal.gov.bd/themes/responsive_npf/img/logo.png' property='og:image'/>";
    $meta_data .= "<meta content='100004176883958' property='fb:admins'/>";
    $meta_data .= "<meta content='566303030074079' property='fb:app_id'/>";
    $meta_data .= "<meta content='bn_BD' property='og:locale'/>";
    $meta_data .= "<meta content='bn_BD' property='og:locale:alternate'/>";
    $meta_data .= "<link href='http://service.portal.gov.bd/' rel='canonical'/>";
    $meta_data .= "<link href='http://a2i.pmo.gov.bd' rel='author'/>";
    $meta_data .= "<link href='http://cabinet.portal.gov.bd/misc/favicon.ico' rel='shortcut icon' type='image/vnd.microsoft.icon'/>";
    $meta_data .= "<link href='http://#' rel='alternate' title='Responsive Theme for Bangladesh Government Service Portal' type='application/atom+xml'/>";
    $meta_data .= "<link href='http://#?alt=rss' rel='alternate' title='Responsive Theme for Bangladesh Government Service Portal - RSS' type='application/rss+xml'/>";
    $meta_data .= "<link href='http://#' rel='alternate' title='Responsive Theme for Bangladesh Government Service Portal - Atom' type='application/atom+xml'/>";

    return $meta_data;
}

function getDomainStyleSheet(){
    $css = '';
 	$css = '<link type="text/css" rel="stylesheet" media="all" href="/themes/responsive_npf/templates/forms/css/style.css" />';
	$css .= '<link type="text/css" rel="stylesheet" media="all" href="/themes/responsive_npf/templates/forms/css/layout.css" />';
	$css .= '<link type="text/css" rel="stylesheet" media="all" href="/themes/responsive_npf/templates/forms/css/colors.css" />';
	$css .= '<link type="text/css" rel="stylesheet" media="all" href="/themes/responsive_npf/templates/forms/css/form.css" />';
	$css .= '<link type="text/css" rel="stylesheet" media="all" href="/themes/responsive_npf/templates/forms/css/typography.css" />';
	$css .= '<link type="text/css" rel="stylesheet" media="all" href="/themes/responsive_npf/templates/forms/css/maintenance-page.css" />';
	$css .= '<link type="text/css" rel="stylesheet" media="all" href="/themes/responsive_npf/templates/forms/css/ie6.css" />';
	$css .= '<link type="text/css" rel="stylesheet" media="all" href="/themes/responsive_npf/templates/forms/css/jquery.simplyscroll.css" />';



    return $css;
}

function getHeaderTop()
{
    $content = '';
    $content .= '<div class="content-wrapper">';
        $content .= '<div id="header-top-left"><a href="#"><i class="flaticon-menu10"></i></a></div><!-- /header-top-left -->';
        $content .= '<div id="header-top-right">';
            $content .= '<a href="#"><i class="flaticon-facebook6"></i></a>';
            $content .= '<a href="#"><i class="flaticon-social19"></i></a>';
            $content .= '<a href="#"><i class="flaticon-google42"></i></a>';
            $content .= '<a href="#"><i class="flaticon-rss11"></i></a>';
            $content .= '<a href="#"><i class="flaticon-email26"></i></a>';
            $content .= '<a href="#"><i class="flaticon-magnifier12"></i></a>';
        $content .= '</div><!-- /header-top-right -->';
    $content .= '</div><!-- /content-wrapper -->';

    return $content;
}

function getHeaderLeft()
{
    $content = '';
    $content .= '<div id="site-intro">';
        $content .= '<img src="/themes/responsive_npf/templates/services/images/logo.png"  height="51" alt="Logo Bangladesh Government">';
        $content .= '<div id="site-name-slogan">';
            $content .= '<h1>সেবা পোর্টাল </h1>';
            $content .= '<span id="slogan">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার </span> <!-- /slogan -->';
        $content .= '</div><!-- /site-name-slogan -->';
    $content .= '</div><!-- /site-intro -->';

    return $content;
}


function getHeaderRight()
{
    $content = '';
    $content .= '<div class="pure-menu pure-menu-open pure-menu-horizontal">';
    $content .= '<a href="#" class="pure-menu-heading"><img src="/themes/responsive_npf/templates/services/images/homebutton.png" width="33" height="29" alt="Home"></a>';
        $content .= '<ul>';
            $content .= '<li class="pure-menu-selected"><a href="#">সেবাসমূহ<i class="flaticon-arrow73"></i></a></li>';
            $content .= '<li><a href="#">দপ্তরসমূহ<i class="flaticon-arrow73"></i></a></li>';
        $content .= '</ul>';
    $content .= '</div> <!-- /pure-menu pure-menu-open pure-menu-horizontal -->';

    return $content;
}

function getScrollingBannerContent(){
        $str_scroll_banner = '';
        $str_scroll_banner .= '<!--<ul id="featured" >-->';
        $str_scroll_banner .= '<ul id="featured">';
        $str_scroll_banner .= '<li id="box-1" class="feature">';
        $str_scroll_banner .= '<div>';
        $str_scroll_banner .= '<div class="feature-icon-wrapper feature-icon-wrapper-green"><i class="flaticon-images11 green"></i></div>';
        $str_scroll_banner .= '<div class="feature-body">';
        $str_scroll_banner .= '<h4>বিধবা ভাতা</h4>';
        $str_scroll_banner .= '<p>জেলা সমাজসেবা অফিস | উপজেলা সমাজসেবা অফিস</p>';
        $str_scroll_banner .= '</div>';

        $str_scroll_banner .= '</div>';
        $str_scroll_banner .= '</li><!-- /feature -->';
        $str_scroll_banner .= '<li id="box-2" class="feature">';
        $str_scroll_banner .= '<div>';
        $str_scroll_banner .= '<div class="feature-icon-wrapper feature-icon-wrapper-red"><i class="flaticon-events red"></i></div>';
        $str_scroll_banner .= '<div class="feature-body">';
        $str_scroll_banner .= '<h4>মাছের পোনা সরবরাহ</h4>';
        $str_scroll_banner .= '<p>জেলা কৃষি অফিস | উপজেলা কৃষি অফিস</p>';
        $str_scroll_banner .= '</div>';
        $str_scroll_banner .= '</div>';
        $str_scroll_banner .= '</li><!-- /feature -->';
        $str_scroll_banner .= '<li id="box-3" class="feature">';
        $str_scroll_banner .= '<div>';
        $str_scroll_banner .= '<div class="feature-icon-wrapper feature-icon-wrapper-blue"><i class="flaticon-newspapre blue"></i></div>';
        $str_scroll_banner .= '<div class="feature-body">';
        $str_scroll_banner .= '<h4>কাবিখা</h4>';
        $str_scroll_banner .= '<p>উপজেলা নির্বাহী কর্মকর্তার কার্যালয়</p>';
        $str_scroll_banner .= '</div>';
        $str_scroll_banner .= '</div>';
        $str_scroll_banner .= '</li><!-- /feature -->';
        $str_scroll_banner .= '<li id="box-4" class="feature">';
        $str_scroll_banner .= '<div>';
        $str_scroll_banner .= '<div class="feature-icon-wrapper feature-icon-wrapper-green"><i class="flaticon-press4 green"></i></div>';
        $str_scroll_banner .= '<div class="feature-body">';
        $str_scroll_banner .= '<h4>অনলাইন জন্ম নিবন্ধন</h4>';
        $str_scroll_banner .= '<p>উপজেলা নির্বাহী কর্মকর্তার কার্যালয় | ইউআইএসসি</p>';
        $str_scroll_banner .= '</div>';
        $str_scroll_banner .= '</div>';
        $str_scroll_banner .= '</li><!-- /feature -->';

        $str_scroll_banner .= '</ul><!-- /featured -->';

        return $str_scroll_banner;
}

//////////////////////////////////////////////////////////////////////////////////////
function getNavigation()
{
    $content = '';
    $content .= '<ul id="front-tab-tabs">';
        $content .= '<li id="front-tab-tabs-li-pcat" class="front-tab-tabs-li active"><a href="javascript:front_tab_show(\'pcat\');">খাত অনুসারে</a></li>';
        $content .= '<li id="front-tab-tabs-li-cat" class="front-tab-tabs-li"><a href="javascript:front_tab_show(\'cat\');">ধরণ অনুসারে</a></li>';
        $content .= '<li id="front-tab-tabs-li-org" class="front-tab-tabs-li"><a href="javascript:front_tab_show(\'org\');">দপ্তর অনুসারে</a></li>';
        $content .= '<li id="front-tab-tabs-li-off" class="front-tab-tabs-li"><a href="javascript:front_tab_show(\'off\');">অফিস অনুসারে</a></li>';
    $content .= '</ul>';

    return $content;
}

function getSContentPcat()
{
    $html = '';
    $html .= '<ul>';
    //////////////////////////////////////////////////////
    $sql = 'SELECT lt.id catid,
                    lt.name_bn catname,
                    cs.id id,
                    cs.title_bn title
                    FROM
                    npfministryadmin.npf_lookups lt
                    CROSS JOIN
                    npfministryadmin.npf_content_service_portal cs
                    ON FIND_IN_SET(lt.id, cs.service_pr_cat)
                    WHERE cs.active = 1 AND cs.publish = 1
            ';
    //echo $sql;exit;
    $result = db_query($sql);
    $a_result = array();
    $flg = false;
    //var_dump($result);exit;

    while($row = db_fetch_object($result))
    {
        $flg = true;
        $a_result[] = get_object_vars($row);
    }

    //var_dump($a_result);exit;
    ///////////////////////////////////////////
    $content_body = '';
    if($flg){
        $t_result = makeArrayGroup(array('catname'), $a_result);
        $i = 1;
        foreach($t_result as $slnks)
        {
            //var_dump($slnks[0]);
            $content_body .= '<li>';
            $content_body .= '<div>';
            $content_body .= '<i class="flaticon-menu10 green"></i>';

            $content_body .= '<a href="javascript:;">'.$slnks[0]['catname'].'<span>('.sizeof($slnks).')</span></a>';
            if($i==1)
            {
                $content_body .= '<a class="see-all" href="javascript:;" onclick="back_tab_show(this,\''.$i.'\');">সব দেখুন<i class="flaticon-arrow555"></i></a>';
                //$content_body .= '<a style="background-color:'.$c_arr[$r_keys[$key]].' !important;" class="service_cat_btn" href="/site/view/services_pc?t='.$slnks[0]['catid'].'&m='.$slnks[0]['catname'].'">'.$slnks[0]['catname'].' &nbsp;('.sizeof($slnks).')</a>';
                $content_body .= '<div class="office-content" id="office-content-'.$i.'" style="">';
                $content_body .= '<ul class="office-content-ul">';
            }
            else
            {
                $content_body .= '<a class="see-all" href="javascript:;" onclick="back_tab_show(this,\''.$i.'\');">সব দেখুন<i class="flaticon-arrow554"></i></a>';
                //$content_body .= '<a style="background-color:'.$c_arr[$r_keys[$key]].' !important;" class="service_cat_btn" href="/site/view/services_pc?t='.$slnks[0]['catid'].'&m='.$slnks[0]['catname'].'">'.$slnks[0]['catname'].' &nbsp;('.sizeof($slnks).')</a>';
                $content_body .= '<div class="office-content" id="office-content-'.$i.'" style="display: none;">';
                $content_body .= '<ul class="office-content-ul">';
            }

            foreach($slnks as $lnk){
                //$content_body .= '<li><a href="/site/service_portal/'.$lnk['id'].'">'.$lnk['title'].'</a></li>';
                ///////////////////////////////////////////////////////////////////
                $content_body .= '<li class="office-content-ul-li">';
                $content_body .= '<div class="office-content-title float-left">';
                $content_body .= '<i class="flaticon-arrow73"></i><a href="/site/service_portal/'.$lnk['id'].'">'.$lnk['title'].'</a>';
                $content_body .= '</div>';
                $content_body .= '<div class="office-content-right float-right" id="short-links">';

                /*
                $content_body .= '<a class="short-btn short-bg-add" href="#">অনলাইন আবেদন</a>';
                $content_body .= '<a class="short-btn short-bg-a2iviolet" href="#">আবেদন ফরম</a>';
                $content_body .= '<a class="short-btn short-bg-a2igreen" href="#">নমুনা আবেদন</a>';
                */

                $content_body .= '<i class="flaticon-newspapre"></i>';
                $content_body .= '<i class="flaticon-order"></i>';
                $content_body .= '<i class="flaticon-press4"></i>';

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
    $html .= $content_body;
    $html .= '</ul>';

    return $html;
}

//////////////////////////////////////////////////////////////////////////////////////

function getAdvertisement()
{
    $advertise_content='';
    $advertise_content .= '<div id="block-1" class="block right"  style="border: 10px solid #EFEFEF; padding: 2px;">';
    $advertise_content .= '<img src="/themes/responsive_npf/templates/services/images/noboborsho-311x186.jpg" width="265" height="185">';
    $advertise_content .= '</div>';

    return $advertise_content;
}

function getRightMenu()
{
    $right_menu = '';
    $right_menu .= '<div id="block-2" class="block right">';
    $right_menu .= '<ul>';
            $right_menu .= '<li><i class="flaticon-events violet"></i><a href="#">ইভেন্ট ক্যালেন্ডার</a></li>';
            $right_menu .= '<li><i class="flaticon-social97 green"></i><a href="#">প্রেস রিলিজ</a></li>';
            $right_menu .= '<li><i class="flaticon-press4 orange"></i><a href="#">প্রকাশনা</a></li>';
            $right_menu .= '<li><i class="flaticon-order blue"></i><a href="#">অফিস আদেশ</a></li>';
            $right_menu .= '<li><i class="flaticon-law1 pink"></i><a href="#">পলিসি</a></li>';
            $right_menu .= '<li><i class="flaticon-images11 golden"></i><a href="#">ফটোগ্যালারী</a></li>';
            $right_menu .= '<li><i class="flaticon-newspapre green"></i><a href="#">সার্কুলার</a></li>';
            $right_menu .= '<li><i class="flaticon-rss11 maroon"></i><a href="#">নোটিস</a></li>';
            $right_menu .= '<li><i class="flaticon-start green"></i><a href="#">ভিডিও গ্যালারী</a></li>';
            $right_menu .= '<li><i class="flaticon-folder63 red"></i><a href="#">আর্কাইভ</a></li>';
    $right_menu .= '</ul>';
    $right_menu .= '</div>';

    return $right_menu;
}

function getfooterTopContent()
{
    $top_footer_content = '';

    $top_footer_content .= '<div class="content-wrapper">';
    $top_footer_content .= '<div id="doel" class="float-left">';
    $top_footer_content .= '<img src="/themes/responsive_npf/templates/services/images/doel.png" width="50" height="50" alt="doel">';
    $top_footer_content .= '<ul>';
                $top_footer_content .= '<li>যোগাযোগ</li>';
                $top_footer_content .= '<li>ফিডব্যাক</li>';
                $top_footer_content .= '<li>সচরাচর জিজ্ঞাস্য</li>';
                $top_footer_content .= '<li>গোপনীয়তার নীতিমালা</li>';
    $top_footer_content .= '</ul>';
    $top_footer_content .= '</div><!-- doel -->';
        $top_footer_content .= '<div id="copyright" class="float-right">';
            $top_footer_content .= '<table>';
                $top_footer_content .= '<tr>';
                    $top_footer_content .= '<td>পরিকল্পনা ও বাস্তবায়নে:    </td>';
                    $top_footer_content .= '<td><img class="grayscale" src="/themes/responsive_npf/templates/services/images/a2ilogo-final.png" height="50" alt="a2i"></td>';
                    $top_footer_content .= '<td><img class="grayscale" src="/themes/responsive_npf/templates/services/images/logo.png" height="35" alt="bdgovlogo"></td>';
                    $top_footer_content .= '<td><img class="grayscale" src="/themes/responsive_npf/templates/services/images/bcc.png" height="35" alt="bcc"></td>';
                    $top_footer_content .= '<td><img class="grayscale" src="/themes/responsive_npf/templates/services/images/basis.jpg" height="30" alt="basis"></td>';
                $top_footer_content .= '</tr>';
            $top_footer_content .= '</table>';
    $top_footer_content .= '</div><!-- copyright -->';
    $top_footer_content .= '</div><!-- content-wrapper -->';

    return $top_footer_content;
}

function footerBoxFirst()
{
    $content = '';
    $content .= '<iframe width="100%" height="235" src="http://www.youtube.com/embed/8sQd4f76iF0" frameborder="0" allowfullscreen></iframe>';

    return $content;
}

function footerBoxSecond()
{
    $content = '';
    $content .= '<a class="twitter-timeline"  href="https://twitter.com/bdgovservices"  data-widget-id="466633748486688769">Tweets by @bdgovservices</a>';
    $content .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';

    return $content;
}
/////////////////////////////////////////////////////////




function getFContentCat()
{
    $html = '';
    //////////////////////////////////////////////////////
    $sql = 'SELECT lt.id catid,
	    lt.name_bn catname,
	    cs.id id,
	    cs.title_bn title
	    FROM npfministryadmin.npf_content_forms cs
	    LEFT JOIN npfministryadmin.npf_lookups lt
	    ON lt.id = cs.forms_portal_cat
	    LEFT JOIN npfministryadmin.npf_hit_counter_hits_form ht
	    ON cs.id = ht.id
	    WHERE cs.active = 1 AND cs.publish = 1
            GROUP BY cs.id
	    ORDER BY lt.id, ht.count DESC
            ';
    //echo $sql;exit;
    $result = db_query($sql);
    $a_result = array();
    $flg = false;
    //var_dump($result);exit;





    while($row = db_fetch_object($result))
    {
        $flg = true;
        $a_result[] = get_object_vars($row);
    }


  


    //var_dump($a_result);exit;
    ///////////////////////////////////////////
    $content_body = '';
    if($flg){
        $t_result = makeArrayGroup(array('catname'), $a_result);
        $i = 1;
        foreach($t_result as $slnks)
        {	

			$count=1;	

            //var_dump($slnks[0]);
            		$content_body .= '<div class="form-cat-box float-left '.($i%2 ? 'odd':'even').'">';
			$content_body .='<div class="icon-and-count float-left">';
            		$content_body .= '<div class="cat-icon"><i class="flaticon-form-box-'.$i.'"></i></div>';
			$content_body .= '<div class="cat-form-count">'.digit_to_bangla(sizeof($slnks),'bn').'<span style="font-size:20px;"> টি</span>'.'</div>';
			$content_body .= '</div><!-- float-left -->';
			$content_body .= '<div class="cat-box-text-content">';
			$content_body .= '<h5>'.$slnks[0]['catname'].'</h5><hr>';
			
			$content_body .='<ul>';

            foreach($slnks as $lnk){
                $content_body .= '<li><a href="/site/view/form-page/'.$lnk['id'].'">'.teaser_text( $lnk['title'], $charLimit = 35 ).'title="'.$lnk['title'].'" </a></li>';
		  if ($count == 3) break;
                ///////////////////////////////////////////////////////////////////
                //$content_body .= '<i class="flaticon-arrow73"></i><a href="/site/forms/'.$lnk['id'].'">'.$lnk['title'].'</a>';

                //$content_body .='</div><!-- cat-box-text-content -->';   
       	  $count++;

               
            }
            $content_body .= '</ul>';
         

            $content_body .= '</div><!-- cat-box-text-content -->';
			$content_body .='<div class="more-btn"><a href="http://forms.portal.gov.bd/site/view/category_content/'.$slnks[0]['catname'].'">আরও</a></div><!-- more-btn -->';
            $content_body .= '</div>';

            $i++;
        }
    }
    //////////
    $html .= $content_body;

    return $html;
}




function getFContentOff()
{
    $html = '';
    //////////////////////////////////////////////////////
    $sql = 'SELECT
		d.id, d.sitename_bn, count(d.id) "cnt"
		FROM npfministryadmin.npf_content_forms cf
		INNER JOIN npfministryadmin.npf_domains d
		ON cf.domain_id=d.id
		WHERE   cf.active=1 AND cf.publish=1
		GROUP BY d.id
		ORDER BY d.sitename_bn
';

    //echo $sql;exit;
    $result = db_query($sql);
    $a_result = array();
    $flg = false;
    //var_dump($result);exit;





    while($row = db_fetch_object($result))
    {
        $flg = true;
        $a_result[] = get_object_vars($row);
    }


  
$cnt = sizeof($a_result);

    //var_dump($a_result);exit;

                $content_body .= 'Total Forms: '.$cnt.'<ul>';

	foreach($a_result as $links){
              $content_body .= '<li>';
		$content_body .= '<i class="flaticon-arrow73"></i>'.'   ';
		$content_body .= '<a href="http://forms.portal.gov.bd/site/view/form-office/'.$links['id'].'">'.$links['sitename_bn'].'</a>'.' ('.$links['cnt'].')';
              $content_body .= '</li>';


	}
    	
	$html .= $content_body;

	return $html;



}
function breadcrumb(){
	$breadcrumb_uri = $_SERVER['REQUEST_URI'];
	$breadcrumb_uri_arr = explode("/",$breadcrumb_uri);
	$breadcrumb ="";
	$bc='<div id="breadcrumb">';
	if($breadcrumb_uri_arr[2]=="view" and $breadcrumb_uri_arr[3]=="form-page"){	
		$bc .= '<span class="breadcome_element"><a href="http://'.$_SERVER['SERVER_NAME'].'">প্রথম পাতা</a></span>
		  <i class="flaticon-arrow73"></i>
		  <span class="breadcome_element"><a href="http://'.$_SERVER['SERVER_NAME'].'/site/view/all-forms">ফরম</a></span>
		  <i class="flaticon-arrow73"></i>';
	}
	else if ($breadcrumb_uri_arr[2]=="view" and $breadcrumb_uri_arr[3]=="all-forms"){
		$bc .= '<span class="breadcome_element"><a href="http://'.$_SERVER['SERVER_NAME'].'">প্রথম পাতা</a></span>
			  <i class="flaticon-arrow73"></i>';
		
	}	
	else if ($breadcrumb_uri_arr[2]=="view" and $breadcrumb_uri_arr[3]=="category_content"){
		$bc .= '<span class="breadcome_element"><a href="http://'.$_SERVER['SERVER_NAME'].'">প্রথম পাতা</a></span>
		  <i class="flaticon-arrow73"></i>
		  <span class="breadcome_element"><a href="http://'.$_SERVER['SERVER_NAME'].'">ক্যাটাগরী</a></span>
		  <i class="flaticon-arrow73"></i>';
		
	}	
	else if ($breadcrumb_uri_arr[2]=="view" and $breadcrumb_uri_arr[3]=="form-office"){
		$bc .= '<span class="breadcome_element"><a href="http://'.$_SERVER['SERVER_NAME'].'">প্রথম পাতা</a></span>
		  <i class="flaticon-arrow73"></i>
		  <span class="breadcome_element"><a href="http://'.$_SERVER['SERVER_NAME'].'/site/view/form-office-list-front">অফিস</a></span>
		  <i class="flaticon-arrow73"></i>';
		
	}
	else{
		$bc = '<span class="breadcome_element"><a href="http://'.$_SERVER['SERVER_NAME'].'">প্রথম পাতা</a></span>';
	}
	$bc.='</div>';
	return $bc;
}



function hitcounter($domainid=6619){ 

	$page = $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'];
	$page_id_arr = explode("/", $page);
	if(count($page_id_arr)>3){
		if(isValidGuid($page_id_arr[4])){
			$id = $page_id_arr[4];
		}
	} else {
		$id = NULL;
	};

	$sql = "SELECT page, count FROM npfministryadmin.npf_hit_counter_hits_form WHERE page = '$page' AND domain_id = '$domainid'";
	$result = db_query($sql);
		if(mysql_num_rows($result))
		{
			//A counter for this page  already exsists. Now we have to update it.				
			$updatecounter = db_query("UPDATE npfministryadmin.npf_hit_counter_hits_form SET count = count+1 WHERE page = '$page' AND domain_id = '$domainid'");
			if (!$updatecounter) 
			{
				return "Can't update the counter : ";
			}
		
		} 
		else
		{
		// This page did not exsist in the counter database. A new counter must be created for this page.
			$insert = db_query("INSERT INTO npfministryadmin.npf_hit_counter_hits_form (page, count,domain_id,id)VALUES ('$page', '1', '$domainid','$id')");				if (!$insert) 
			{
				return "Can't insert counter data. ";
			}
		}
}

function isValidGuid($guid)
{
	$flg =  !empty($guid) && preg_match('/^\{?[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}\}?$/', $guid); 
    return $flg;
}

function headerMetaContents(){
        $metacontents = '';
        $metacontents .= "<meta charset='utf-8'/>";
        $metacontents .= "<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>";
		$metacontents .="<meta content='বাংলাদেশ সরকারের সকল ফরমের ভাণ্ডার' name='description'/>";
		$metacontents .="<meta content='Bangladesh, Government, forms, Portal, ফরম, সেলামী, চাকুরী' name='keywords'/>";
		$metacontents .="<link href='http://www.forms.gov.bd/' rel='canonical'/>";
		$metacontents .="<link href='http://a2i.pmo.gov.bd' rel='author'/>";
		$metacontents .="<link href='http://cabinet.portal.gov.bd/misc/favicon.ico' rel='shortcut icon' type='image/vnd.microsoft.icon'/>";
		$metacontents .="<link href='http://#' rel='alternate' title='বাংলাদেশ সরকারের ফরম' type='application/atom+xml'/>";
		$metacontents .="<link href='http://#?alt=rss' rel='alternate' title='বাংলাদেশ সরকারের ফরম - RSS' type='application/rss+xml'/>";
		$metacontents .="<link href='http://#' rel='alternate' title='বাংলাদেশ সরকারের ফরম - Atom' type='application/atom+xml'/>";
		$metacontents .="<meta content='a2i' name='author'/>";
		$metacontents .="<meta content='বাংলাদেশ সরকারের ফরম' property='og:title'/>";
		$metacontents .="<meta content='website' property='og:type'/>";
		$metacontents .="<meta content='এই সাইটে বাংলাদেশ সরকারের বিভন্ন দপ্তরের সেবাসমূহের ফরম সহজে খুঁজে পাওয়া যাবে। শেয়ার করে অপরকে এ সুবিধা পেতে সহযোগীতা করুন।' property='og:description'/>";
		$metacontents .="<meta property='og:image' content='http://www.forms.gov.bd/themes/responsive_npf/templates/forms/fblogo.png'/>";
		$metacontents .="<meta property='og:url' content='http://www.forms.gov.bd' />";
		$metacontents .="<meta content='1481022187' property='fb:admins'/>";
		$metacontents .="<meta content='882831951732265' property='fb:app_id'/>";
		$metacontents .="<meta content='bn_IN' property='og:locale'/>";
		$metacontents .="<meta content='bn_IN' property='og:locale:alternate'/>";
        return $metacontents;
}




