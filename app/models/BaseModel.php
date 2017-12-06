<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

/**
 * Vokuro\Models\Contents
 *
 * All the users registered in the application
 */
class BaseModel extends Model
{
    protected  function getDatetime(){
        $date = new \DateTime();
        return $date->format("Y-m-d H:i:s");
    }
}