<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Mvc\Url,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Models\NpfMenus;
use Vokuro\Models\NpfDomains;

class MenusController extends ControllerBase
{
    public $uuids = array();

    private function getUuidFor($id){
        if(!isset($this->uuids[$id])){
            $this->uuids[$id] = $this->getUuid();
        }
        return $this->uuids[$id];
    }
    private function getUuidForParent($id){
        if($this->startsWith($id, "new-")){
            if(!isset($this->uuids[$id])){
                return 0;
            }
            return $this->uuids[$id];
        }
        return $id;
    }
    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }
    private function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
    private function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    public function saveAjaxAction(){

        $domain_id = $this->getDomainId();
        $a_result = "started";
        // Check whether the request was made with method POST
        if ($this->request->isPost() == true) {

            // Check whether the request was made with Ajax
            if ($this->request->isAjax() == true)
            {
                $this->view->disable();
                $data = json_decode(''.$this->request->getPost('mns'));

                foreach($data as $menu){
                    $tt = get_object_vars($menu);
                    if(count($tt)>0){
                        //var_dump($tt);
                        $npfMenu = null;
                        if($this->startsWith($tt['id'], "new-")){
                            $npfMenu = new NpfMenus();
                            $npfMenu->assign(array(
                                'id' => $this->getUuidFor(''.$tt['id']),
                                'title_bn' => $tt['title_bn'],
                                'title_en' => $tt['title_en'],
                                'link_path' => $tt['link_path'],
                                'link_type' => $tt['link_type'],
                                'external' => $tt['external'],
                                'active' => $tt['active'],
                                'weight' => $tt['weight'],
                                'depth' => $tt['depth'],
                                'parent_id' => $this->getUuidForParent(''.$tt['parent_id']),
                                'has_children' => $tt['has_children'],
                                'menu_type_id' => 1,
                                'domain_id' => $domain_id,
                            ));
                            //var_dump($npfMenu);
                        }else{
                            $npfMenu = NpfMenus::findFirstById($tt['id']);

                            $npfMenu->assign(array(
                                'title_bn' => $tt['title_bn'],
                                'title_en' => $tt['title_en'],
                                'link_path' => $tt['link_path'],
                                'link_type' => $tt['link_type'],
                                'external' => $tt['external'],
                                'active' => $tt['active'],
                                'weight' => $tt['weight'],
                                'has_children' => $tt['has_children'],
                                'depth' => $tt['depth'],
                                'parent_id' => $this->getUuidForParent(''.$tt['parent_id']),
                            ));
                            //var_dump($npfMenu);
                        }
                        if (!$npfMenu->save()) {
                            $a_result = json_encode(array("result"=>"fail"));
                        }else{
                            $a_result = $this->getMenuContent();
                        }
                    }
                }

            }
        }
        $response = new Response();
//        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($a_result);
        return $response;
    }

    public function indexAction()
    {

        $this->view->menu = $this->getMenuContent();

        $this->view->url = $this->getDomainPath();
    }
    private function getMenuContent(){
        $domain_id = $this->getDomainId();
        $npfMenus = NpfMenus::getMenusByDomainId($domain_id);
        $a_result = array();
        foreach($npfMenus as $menu){

            $a_result[] = get_object_vars($menu);
        }
        $tree = $this->get_menu($a_result);

        $menu = $this->buildMenu($tree);

        return $menu;
    }
    private function buildMenu($tree){
        $menu = '<div class="dd" id="nestable3"><ol class="dd-list" id="menu-editor">';
        $btns = '<div style="float:right;margin-top: -3px; "><a href="javascript:;" class="menu-edit btn btn-mini btn-warning"><i class="icon-edit"></i></a></div>';
        if(sizeof($tree)>0){
        foreach($tree[0] as $leaf){
            $t = $leaf;
            $jsonStr = json_encode($t);
            $active = $leaf['active']=="1"?"active":"deactive";
            $menu .= '<li class="dd-item dd3-item" data-id="'.$leaf['id'].'">';
            $menu .= '<div class="data-value" style="display:none">'.$jsonStr.'</div>';
            $menu .= '<div class="dd-handle dd3-handle"></div><div class="dd3-content"><span class="title-bn '.$active.'">'.$leaf['title_bn']."</span>".$btns.'</div>';
            //$menu .= $btns;
            $cmenu = '';
            if($leaf['has_children']=="1"){
                $cmenu = $this->buildMenuList($tree,$leaf['id']);
            }
            $menu .= $cmenu;
            $menu .= '</li>';
        }
        }
        $menu .= '</ol></div>';

        return $menu;
    }

    private function buildMenuList(&$tree,$p_id){
        if(!isset($tree[$p_id])){return "";}

        $btns = '<div style="float:right;margin-top: -3px; "><a href="javascript:;" class="menu-edit btn btn-mini btn-warning"><i class="icon-edit"></i></a></div>';
        $children = $tree[$p_id];

        $inner_menu = '';
        foreach($children as $child){
            $child_menu = '';
            $active = $child['active']=="1"?"active":"deactive";
            $t = $child;
            $jsonStr = json_encode($t);
            $inner_menu .= '<li class="dd-item dd3-item" data-id="'.$child['id'].'">';
            $inner_menu .= '<div class="data-value" style="display:none">'.$jsonStr.'</div>';
            $inner_menu .= '<div class="dd-handle dd3-handle"></div><div class="dd3-content"><span class="title-bn '.$active.'">'.$child['title_bn']."</span>".$btns.'</div>';
            if($child['has_children']=="1"){
                $child_menu = $this->buildMenuList($tree,$child['id']);
            }
            $inner_menu .= $child_menu;
            $inner_menu .= '</li>';
        }

        $menu = '<ol class="dd-list">';
        $menu .= $inner_menu;
        $menu .= '</ol>';

        return $menu;
    }

    private function get_menu($arr){
        $new = array();
        if(sizeof($arr)){

            foreach ($arr as $a){
                $new[$a['parent_id']][] = $a;
            }
        }
        return $new;
    }

}

