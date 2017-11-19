<?php

namespace Vokuro\Controllers;

use Vokuro\Models\HitCounter;

class HitstatController extends ControllerBase
{

    public function initialize()
    {
//        $this->setViewTemplate();
//        $this->view->profile = $this->getUserProfile();
    }

    public function indexAction(){

        $domainid = $this->getDomainId();

        $result = HitCounter::getTotalHit($domainid);
        $this->view->totalhits = $result[0]->totalhits  ;

        $result = HitCounter::getHits($domainid);
        $this->view->hits = $result;
    }

    public function visitorsAction(){

        $domainid = $this->getDomainId();

        $result = HitCounter::getTotalUniqueIps($domainid);
        $this->view->totalips = $result[0]->totalips;

        $result = HitCounter::getVisitors($domainid);
        $this->view->visitors = $result;
    }
}

