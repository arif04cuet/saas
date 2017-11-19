<?php


namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;


class NpfOfficeUsers extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $int;
     
    /**
     *
     * @var integer
     */
    public $office_id;
     
    /**
     *
     * @var integer
     */
    public $user_id;
     
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
            'int' => 'int', 
            'office_id' => 'office_id', 
            'user_id' => 'user_id', 
            'created' => 'created', 
            'lastmodified' => 'lastmodified', 
            'createdby' => 'createdby', 
            'lastmodifiedby' => 'lastmodifiedby'
        );
    }
    public function initialize()
    {
        $this->belongsTo('user_id', 'Vokuro\Models\Users', 'id', array(
            'alias' => 'user'
        ));
        $this->belongsTo('office_id', 'Vokuro\Models\NpfOffices', 'id', array(
            'alias' => 'office'
        ));
    }
}
