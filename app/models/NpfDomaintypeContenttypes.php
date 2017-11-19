<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;


class NpfDomaintypeContenttypes extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;
    /**
     *
     * @var integer
     */
    public $domain_type_id;
     
    /**
     *
     * @var string
     */
    public $content_type_ids;
     

     
    /**
     *
     * @var string
     */
    public $created;
     
    /**
     *
     * @var string
     */
    public $lastmodified;
     
    /**
     *
     * @var integer
     */
    public $createdby;
     
    /**
     *
     * @var integer
     */
    public $lastmodifiedby;

    public function beforeCreate(){
        $this->created = $this->getDatetime();
        $this->lastmodified = $this->getDatetime();
    }
    public function beforeUpdate(){
        $this->lastmodified = $this->getDatetime();
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'domain_type_id' => 'domain_type_id',
            'content_type_ids' => 'content_type_ids',
            'created' => 'created',
            'lastmodified' => 'lastmodified', 
            'createdby' => 'createdby',
            'lastmodifiedby' => 'lastmodifiedby',
        );
    }
}
