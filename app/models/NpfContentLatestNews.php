<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;


class NpfContentLatestNews extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $title_bn;
    /**
     *
     * @var string
     */
    public $title_en;

    public $domain_id;

    public $uuid;

    public $content_type;

    public function beforeCreate()
    {
        $this->created = $this->getDatetime();
        $this->lastmodified = $this->getDatetime();
        $this->version = 1;
        $this->active = 1;
        $this->publish = 1;
    }

    public function beforeUpdate()
    {
        $this->lastmodified = $this->getDatetime();
        $this->version = 1;
    }

    /**
     * Independent Column Mapping.
     */


    public static function iSLatestNewsCheckBox($contentType, $domain)
    {
        $allowedDomain = array(
            'mopa.portal.gov.bd',
            'bangladesh.gov.bd'
        );

        if (in_array($domain, $allowedDomain))
            return true;

        return false;
    }
}
