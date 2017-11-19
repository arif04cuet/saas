<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

/**
 * Vokuro\Models\Contents
 *
 * All the users registered in the application
 */
class HitCounter extends Model
{


    public static function getTotalHit($domain_id){

        $sql = "SELECT SUM(count)  AS totalhits FROM npf_hit_counter_hits WHERE `domain_id` = $domain_id";
        $content = new HitCounter();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function getHits($domain_id){

        $sql = "SELECT * FROM npf_hit_counter_hits WHERE `domain_id` = $domain_id ORDER BY count DESC ";
        $content = new HitCounter();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function getTotalUniqueIps($domain_id){

        $sql = "SELECT MAX(id) AS totalips FROM npf_hit_counter_info WHERE `domain_id` = $domain_id";
        $content = new HitCounter();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }
    public static function getVisitors($domain_id){

        $sql = "SELECT * FROM npf_hit_counter_info WHERE `domain_id` = $domain_id ORDER BY id DESC";
        $content = new HitCounter();
        return new Resultset(null, $content, $content->getReadConnection()->query($sql));
    }

}