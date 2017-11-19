<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Models\Contents;
use Vokuro\Forms\NpfDomainsForm;
use Vokuro\Models\NpfDomains;
use Vokuro\Models\NpfDomainTypes;
use Vokuro\Models\NpfLookupTypes;
use Vokuro\Models\NpfLookups;


class DomainsController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function pdf()
    {

    }

    public function regexAction()
    {

    }

    private function ifInt($val)
    {

    }

    private function ifAlpha($val)
    {

    }

    private function ifAlphaNum($val)
    {

    }

    private function if_AlphaNum($val)
    {

    }

    private function ifEmail($val)
    {

    }

    private function ifUrl($val)
    {

    }

    private function getDomainStatus($status, $lan = 'bn')
    {
        $statusTitle = array(
            1 => array('bn' => 'সতন্ত্র ওয়েবসাইট', 'en' => 'External Link'),
            2 => array('bn' => 'পোর্টালে অন্তর্ভুক্ত', 'en' => 'Moved In the portal'),
            3 => array('bn' => 'প্রক্রিয়াধীন', 'en' => 'Moving in the portal'),
            4 => array('bn' => 'ওয়েবসাইট নাই', 'en' => 'Currently have no site')

        );

        return $statusTitle[$status][$lan];
    }

    public function makeArrayGroupAction()
    {

        $data = array();
        $data[] = array('f1' => 'f1', 'f2' => 'f11', 'f3' => 'f111', 'name' => 'test111');
        $data[] = array('f1' => 'f1', 'f2' => 'f11', 'f3' => 'f112', 'name' => 'test112');
        $data[] = array('f1' => 'f1', 'f2' => 'f11', 'f3' => 'f113', 'name' => 'test113');
        $data[] = array('f1' => 'f1', 'f2' => 'f12', 'f3' => 'f121', 'name' => 'test121');
        $data[] = array('f1' => 'f1', 'f2' => 'f12', 'f3' => 'f122', 'name' => 'test122');
        $data[] = array('f1' => 'f2', 'f2' => 'f21', 'f3' => 'f211', 'name' => 'test211');
        $data[] = array('f1' => 'f2', 'f2' => 'f21', 'f3' => 'f212', 'name' => 'test212');
        $data[] = array('f1' => 'f2', 'f2' => 'f22', 'f3' => 'f221', 'name' => 'test221');
        $data[] = array('f1' => 'f2', 'f2' => 'f22', 'f3' => 'f222', 'name' => 'test222');
        $data[] = array('f1' => 'f2', 'f2' => 'f22', 'f3' => 'f223', 'name' => 'test223');

        $group = array('f1', 'f2');

        $group_size = sizeof($group);
//        echo $group_size;
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
//        var_dump($this->search($data,'f1','f1'));
        $this->DFS($group[$group_size - 1], $data, $result);
//        var_dump($result);
//        var_dump($result['f2']);
    }

    private function DFS($f, $data, &$tmp)
    {
        foreach ($tmp as $key => &$val) {
            if (is_array($val) && (sizeof($val) > 0)) {
                $this->DFS($f, $data, $val);
            } else {
                $tmp_key = $this->search($data, $f, $key);
                $tmp[$key] = $tmp_key;
            }
        }
    }

    private function search($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }

    public function getvalsbytypeAction()
    {
        $taxonomy = array();
        $typeid = $this->request->getQuery("tp", "int");
        $lookupType = NpfLookupTypes::findFirstById($typeid);
        if ($lookupType) {
            if ($lookupType->lookuptype_id) {
                // if not common than filter by domain
                $result = NpfLookups::find('lookuptype_id=' . $lookupType->lookuptype_id);
                foreach ($result as $r) {
                    $taxonomy[] = array('id' => $r->id, 'name' => $r->name_bn);
                }
            }
        }

        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($taxonomy));
        return $response;
    }

    public function getvalsbyparentAction()
    {
        $taxonomy = array();
        $parentid = $this->request->getQuery("pid", "int");
        $result = NpfLookups::find('parent_id=' . $parentid);
        if ($result) {
            foreach ($result as $r) {
                $taxonomy[] = array('id' => $r->id, 'name' => $r->name_bn);
            }
        }
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($taxonomy));
        return $response;
    }

    public function getdomainsAction()
    {
        $this->view->disable();
        $childs = array();
        if (($this->request->isPost()) && ($this->request->isAjax() == true)) {
            $lang = $this->request->getQuery("ln", "string");
            $domaintypeid = $this->request->getQuery("dtid", "int");
            $tmp = array();
            if ($domaintypeid) {
                $tmp = NpfDomains::find("active=1 and domain_type_id=" . $domaintypeid);
            } else {

                $parentdomain = $this->request->getQuery("dn", "string");
                $parent = NpfDomains::findFirst("subdomain='" . $parentdomain . "'");

                if ($parent) {
                    $tmp = NpfDomains::find("active=1 and parent_id=" . $parent->id);
                }
            }

            $i = 0;
            foreach ($tmp as $t) {
                if ($lang == 'bn') {
                    $childs[$i] = array('domainname' => $t->subdomain, 'name' => $t->sitename_bn);
                } else if ($lang == 'en') {
                    $childs[$i] = array('domainname' => $t->subdomain, 'name' => $t->sitename_en);
                }
                $i++;
            }
        }
//        var_dump($childs);

        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }

    public function getdomainidsAction()
    {
        $this->view->disable();
        $childs = array();
        if (($this->request->isPost()) && ($this->request->isAjax() == true)) {
            $lang = $this->request->getQuery("ln", "string");
            $domaintypeid = $this->request->getQuery("dtid", "int");
            $tmp = array();
            if ($domaintypeid) {
                $tmp = NpfDomains::find("active=1 and domain_type_id=" . $domaintypeid);
            } else {

                $did = $this->request->getQuery("did", "int");
//                $parent = NpfDomains::findFirst("id='".$did."'");

                if ($did) {
                    $tmp = NpfDomains::find("active=1 and parent_id=" . $did);
                }
            }
            foreach ($tmp as $t) {
                if ($lang == 'bn') {
                    $childs[] = array('did' => $t->id, 'name' => $t->sitename_bn);
                } else if ($lang == 'en') {
                    $childs[] = array('did' => $t->id, 'name' => $t->sitename_en);
                }

            }
        }
//        var_dump($childs);

        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }

    public function getministriesAction()
    {


        $domains = array();
        //if ($this->request->isAjax() == true)
        {
            $callback = $this->request->getQuery("callback", "string");
            $lang = $this->request->getQuery("ln", "string");
            $sotrtBy = ' weight,sitename_' . $lang;
            $data = array();
            $ministries = NpfDomains::find(array(
                "conditions" => "active=1 and domain_type_id=2",
                "order" => "$sotrtBy"
            ));


            foreach ($ministries->toArray() as $ministry) {
                $data[$ministry['id']] = $ministry;
                $data[$ministry['id']]['url'] = ($ministry['site_status'] == 1) ? $ministry['external_link'] : $ministry['subdomain'];
                $data[$ministry['id']]['url'] = (strpos($data[$ministry['id']]['url'], 'http://') !== 0) ? 'http://' . $data[$ministry['id']]['url'] : $data[$ministry['id']]['url'];
                $data[$ministry['id']]['name'] = $ministry['sitename_' . $lang];
                $data[$ministry['id']]['progress_status'] = $ministry['site_status'];
                $data[$ministry['id']]['site_status'] = $this->getDomainStatus($ministry['site_status'], $lang);


                $allChilds = NpfDomains::find(array(
                    "conditions" => "active=1 and parent_id=" . $ministry['id'],
                    "order" => $sotrtBy
                ));
                $directorates = array();
                $institute = array();
                $division = array();
                if (count($allChilds))
                    foreach ($allChilds->toArray() as $child) {

                        $child['url'] = ($child['site_status'] == 1) ? $child['external_link'] : $child['subdomain'];
                        $child['url'] = (strpos($child['url'], 'http://') !== 0) ? 'http://' . $child['url'] : $child['url'];
                        $child['name'] = $child['sitename_' . $lang];
                        $child['progress_status'] = $child['site_status'];
                        $child['site_status'] = $this->getDomainStatus($child['site_status'], $lang);

                        switch ($child['domain_type_id']) {
                            case 3:
                                $directorates[] = $child;
                                break;
                            case 4:
                                $division[] = $child;
                                break;
                            case 13:
                                $institute[] = $child;
                                break;

                        }
                    }

                if ($directorates)
                    $data[$ministry['id']]['child']['directorate'] = $directorates;
                if ($division)
                    $data[$ministry['id']]['child']['division'] = $division;
                if ($institute)
                    $data[$ministry['id']]['child']['institute'] = $institute;

            }
        }
        $this->view->linkList = $data;
        $this->view->ln = $lang;
        $template = $this->view->getRender('domains', 'getministries', null, function ($view) {
            $view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        });
        echo 'getMenuHtml('.json_encode(array('html' => $template)).')';
        //echo $template;
        exit;

    }

    public function getdirectoriesAction()
    {
        $this->view->disable();
        $domains = array();
        $callback = $this->request->getQuery("callback", "string");
        $lang = $this->request->getQuery("ln", "string");

        $tmp = array();

        if ($lang == 'bn') {
            $tmp = NpfDomains::find(array(
                "conditions" => "active=1 and (domain_type_id=3) and id<>3",
                "order" => "sitename_bn"
            ));
        } else {
            $tmp = NpfDomains::find(array(
                "conditions" => "active=1 and (domain_type_id=3) and id<>3",
                "order" => "sitename_en"
            ));
        }
        $test = array();
        foreach ($tmp as $t) {
            $test[] = $t;
        }
        foreach ($test as $t) {
            $tmp = array();
            if ($lang == 'bn') {
                if ($t->site_status = 1) {
                    $tmp = array('domainname' => $t->external_link, 'name' => $t->sitename_bn);
                } else {
                    $tmp = array('domainname' => $t->subdomain, 'name' => $t->sitename_bn);
                }
            } else {
                if ($t->site_status = 1) {
                    $tmp = array('domainname' => $t->external_link, 'name' => $t->sitename_en);
                } else {
                    $tmp = array('domainname' => $t->subdomain, 'name' => $t->sitename_en);
                }
            }
            $domains[$t->id] = $tmp;
        }

        $t = array('type' => 'directories', 'data' => $domains);
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($callback . '(' . json_encode($t) . ')');
        return $response;
    }


    public function getserviceminsAction()
    {
        $this->view->disable();
        $domains = array();

        $callback = $this->request->getQuery("callback", "string");
        $lang = $this->request->getQuery("ln", "string");

        $tmp = array();
        $tmp = NpfDomains::find(array(
            "conditions" => "active=1 and (domain_type_id=2 or domain_type_id=3 or domain_type_id=8)",
            "order" => " weight"
        ));

        $test = array();
        foreach ($tmp as $t) {
            $test[] = $t;
        }

        foreach ($test as $t1) {
            $tmp1 = array();

            //////////////////office content type information/////////////////////
            $service_sql1 = "SELECT id off_c_id FROM npf_content_offices_information WHERE domain='" . $t1->id . "'
					 AND active = 1 AND publish = 1 limit 1";
            $service_tmp1 = Contents::run_sql($service_sql1);
            if (count($service_tmp1) > 0) {
                foreach ($service_tmp1 as $ser_t1) {
                    $off_c_id1 = $ser_t1->off_c_id;
                    break;
                }
            } else {
                $off_c_id1 = "";
            }
            //////////////////office content type information/////////////////////

            if ($t1->site_status == 1) {
                $tmp1 = array('domainname' => $t1->external_link, 'name' => $t1->sitename_bn, 'off_c_id' => $off_c_id1, 'id' => $t1->id);
            } else {
                $tmp1 = array('domainname' => $t1->subdomain, 'name' => $t1->sitename_bn, 'off_c_id' => $off_c_id1, 'id' => $t1->id);
            }

            if ($t1->domain_type_id == 2) {
                $domains[$t1->id] = $tmp1;
            }
        }

        foreach ($test as $t2) {
            $tmp2 = array();

            //////////////////office content type information/////////////////////
            $service_sql2 = "SELECT id off_c_id FROM npf_content_offices_information WHERE domain='" . $t2->id . "'
					 AND active = 1 AND publish = 1 limit 1";
            $service_tmp2 = Contents::run_sql($service_sql2);
            if (count($service_tmp2) > 0) {
                foreach ($service_tmp2 as $ser_t2) {
                    $off_c_id2 = $ser_t2->off_c_id;
                    break;
                }
            } else {
                $off_c_id2 = "";
            }
            //////////////////office content type information/////////////////////

            if ($t2->site_status == 1) {
                $tmp2 = array('domainname' => $t2->external_link, 'name' => $t2->sitename_bn, 'off_c_id' => $off_c_id2, 'id' => $t2->id);
            } else {
                $tmp2 = array('domainname' => $t2->subdomain, 'name' => $t2->sitename_bn, 'off_c_id' => $off_c_id2, 'id' => $t2->id);
            }

            if ($t2->domain_type_id == 3) {
                if (($t2->parent_id != -1) && ($t2->parent_id != 0)) {
                    if (isset($domains[$t2->parent_id])) {
                        $domains[$t2->parent_id]['childs'][] = $tmp2;
                    }
                }
            }
        }

        $total = array('type' => 'ministries', 'data' => $domains);
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($callback . '(' . json_encode($total) . ')');
        return $response;
    }

    public function getdivisionstreeAction()
    {
        $this->view->disable();

        $root = explode('-', $this->request->getPost('root'));
        $parentId = $root[0];
        $lang = $root[1];

        $language = array('en' => array('Upazila', 'Union'), 'bn' => array('উপজেলা', 'ইউনিয়ন'));

        $districts = NpfDomains::find(array(
            "conditions" => "parent_id = $parentId AND active = 1",
            "order" => ' weight,sitename_' . $lang
        ));
        $data = array();
        foreach ($districts as $district) {
            $title = 'sitename_' . $lang;
            $url = (strpos($district->subdomain, 'http://') !== 0) ? 'http://' . $district->subdomain : $district->subdomain;

            $upazilas = NpfDomains::find(array(
                "conditions" => "parent_id = $district->id AND active = 1",
                "order" => ' weight,sitename_' . $lang
            ));

            $tmp = array(
                'text' => '<a href="' . $url . '" target="_blank">' . $district->{$title} . ' ( ' . count($upazilas) . ' ' . $language[$lang][0] . ' )</a>',
                'expanded' => false,
                'classes' => 'district',
                'children' => array(),
            );


            foreach ($upazilas as $key => $upazila) {
                $url = (strpos($upazila->subdomain, 'http://') !== 0) ? 'http://' . $upazila->subdomain : $upazila->subdomain;

                $unions = NpfDomains::find(array(
                    "conditions" => "parent_id = $upazila->id AND active = 1",
                    "order" => ' weight,sitename_' . $lang
                ));

                $tmp['children'][$key] = array(
                    'text' => '<a href="' . $url . '" target="_blank">' . $upazila->{$title} . ' ( ' . count($unions) . ' ' . $language[$lang][1] . ' )</a>',
                    'expanded' => false,
                    'classes' => 'upazila',
                );

                foreach ($unions as $union) {
                    $url = (strpos($union->subdomain, 'http://') !== 0) ? 'http://' . $union->subdomain : $union->subdomain;
                    $tmp['children'][$key]['children'][] = array(
                        'text' => '<a href="' . $url . '" target="_blank">' . $union->{$title} . '</a>',
                        'classes' => 'union',
                    );
                }
            }
            $data[] = $tmp;
        }

        echo json_encode($data);
        exit;
    }

    public function getdivisionsAction()
    {
        $this->view->disable();
        $domains = array();
        $callback = $this->request->getQuery("callback", "string");
        $lang = $this->request->getQuery("ln", "string");

        $tmp = array();
        $sotrtBy = ' weight,sitename_' . $lang;

        if ($lang == 'bn') {
            $tmp = NpfDomains::find(array(
                "conditions" => "(domain_type_id=4 or domain_type_id=5) AND active = 1",
                "order" => "sitename_bn"
            ));
        } else {
            $tmp = NpfDomains::find(array(
                "conditions" => "(domain_type_id=4 or domain_type_id=5) AND active = 1",
                "order" => "sitename_en"
            ));
        }
        $test = array();
        foreach ($tmp as $t) {
            $test[] = $t;
        }
        foreach ($test as $t) {

            $tmp = array();
            if ($lang == 'bn') {
                $tmp = array('domainname' => $t->subdomain, 'name' => $t->sitename_bn);
            } else {
                $tmp = array('domainname' => $t->subdomain, 'name' => $t->sitename_en);
            }
            if ($t->domain_type_id == 4) {
                $domains[$t->id] = $tmp;
            }
        }

        foreach ($test as $t) {

            $tmp = array();
            if ($lang == 'bn') {
                $tmp = array('domainname' => $t->subdomain, 'name' => $t->sitename_bn);
            } else {
                $tmp = array('domainname' => $t->subdomain, 'name' => $t->sitename_en);
            }
            if ($t->domain_type_id == 5) {
                $domains[$t->parent_id]['childs'][] = $tmp;
            }
        }


        $t = array('type' => 'divisions', 'data' => $domains);
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($callback . '(' . json_encode($t) . ')');
        return $response;
    }

    public function demoAction()
    {
        $t = $this->request->get();
        //domain type id
        foreach ($t as $key => $item) {
            if ($key == '_url') continue;
//            echo $key;
            $tt = array_keys($item);
            $tt = implode(',', $tt);
            var_dump($tt);
        }
//        var_dump($t);
        $demo = array();
        $demo[100] = 'demo1';
        $demo[200] = 'demo1';
        $demo[300] = 'demo1';
        $demo[400] = 'demo1';

        foreach ($demo as $key => $item) {
//            echo $key.' '.$item.' ';
        }
    }


}


