<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;


class NpfTemplateBlocks extends BaseModel
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
    public $name;


    /**
     *
     * @var string
     */
    public $sql;

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
     
    /**
     *
     * @var string
     */
    public $volt_bn;
     
    /**
     *
     * @var string
     */
    public $volt_en;
     
    /**
     *
     * @var string
     */
    public $js;

    /**
     *
     * @var string
     */
    public $css;

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
    public $createby;
     
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
            'name' => 'name', 
            'sql' => 'sql',
            'title_bn' => 'title_bn',
            'title_en' => 'title_en', 
            'volt_bn' => 'volt_bn',
            'volt_en' => 'volt_en',
            'js' => 'js',
            'css' => 'css',
            'created' => 'created',
            'lastmodified' => 'lastmodified', 
            'createby' => 'createby', 
            'lastmodifiedby' => 'lastmodifiedby'
        );
    }
}
