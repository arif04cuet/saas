<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

use Vokuro\Models\NpfDomainResources;
use Vokuro\Models\NpfDomainDefaultResources;
use Vokuro\Uuid\Uuid;

/**
 * Vokuro\Models\Contents
 *
 * All the users registered in the application
 */
class DomainSetup extends Model
{
    public static function copyDomainResources($domain_type_id,$domain_id,$user_id=17){

        $domainDefaultResources = NpfDomainDefaultResources::findFirst('domain_type_id = '.$domain_type_id);
        if($domainDefaultResources){
            $npfDomainResources = new NpfDomainResources();
            $npfDomainResources->assign(array(
                'domain_id' => $domain_id,
                'content_type_ids' => $domainDefaultResources->content_type_ids,
                'view_ids' => $domainDefaultResources->view_ids,
                'taxonomy_ids' => $domainDefaultResources->taxonomy_ids,
                'createdby' => $user_id,
                'lastmodifiedby' => $user_id,
            ));
            if (!$npfDomainResources->save()) {
                return false;
            } else {
                return true;
            }
        }
    }

    public static function setup($domainId){
        echo Uuid::v4();
//        DomainSetup::setupOffice($domainId);
//        DomainSetup::setupBanner($domainId);
//        DomainSetup::setupMenu($domainId);
//        DomainSetup::setupNotices($domainId);
//        DomainSetup::setupNews($domainId);
//        DomainSetup::setupSubSectionListBlock($domainId);
//        DomainSetup::setupFeedbackBlock($domainId);
//        DomainSetup::setupOfficeHeadBlock($domainId);
//        DomainSetup::setupInternalServicesBlock($domainId);
//        DomainSetup::setupCentralServicesBlock($domainId);
//        DomainSetup::setupImportantLinksBlock($domainId);
//        DomainSetup::setupFooterMenuAndLnkPages($domainId);
    }

    private static function setupOffice($domainId){
    }
    private static function setupBanner($domainId){

        // copy the default image file to the directory
    }
    private static function setupMenu($domainId){
        $sql = "insert  into `npf_menus`(`id`,`title_bn`,`title_en`,`parent_id`,`menu_type_id`,`menu_link_type_id`,`link_path`,`active`,`external`,`has_children`,`depth`,`weight`,`created`,`lastmodified`,`createdby`,`lastmodifiedby`,`router_path`,`domain_id`) values ('01d9e970-12a6-475a-b258-e3ece131a029','হোম','Home','0',1,NULL,'nolink',1,0,1,1,27,NULL,NULL,NULL,NULL,NULL,$domainId)";

    }
    private static function setupNotices($domainId){
//        INSERT INTO `npfministryadmin`.`npf_content_notices`
//            (`id`,`version`,`active`,`publish`,`created`,`lastmodified`,`createdby`,`lastmodifiedby`,`domain_id`,`office_id`,`menu_id`,`title_bn`,`title_en`,`body_bn`,`body_en`,`userpermissionsids`,`uploadpath`,`pubdate`)
//VALUES ('id','version','active','publish','created','lastmodified','createdby','lastmodifiedby','domain_id','office_id','menu_id','title_bn','title_en','body_bn','body_en','userpermissionsids','uploadpath','pubdate');
    }
    private static function setupNews($domainId){

    }
    private static function setupSubSectionListBlock($domainId){

    }
    private static function setupFeedbackBlock($domainId){

    }
    private static function setupOfficeHeadBlock($domainId){

    }
    private static function setupInternalServicesBlock($domainId){

    }
    private static function setupCentralServicesBlock($domainId){

    }
    private static function setupImportantLinksBlock($domainId){

    }
    private static function setupFooterMenuAndLnkPages($domainId){

    }
}