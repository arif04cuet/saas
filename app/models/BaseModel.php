<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class BaseModel extends Model
{
    public function getDatetime()
    {
        $now = new \DateTime();
        return $now->format('Y-m-d H:i:s');
    }
}