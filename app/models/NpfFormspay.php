<?php

namespace Vokuro\Models;

class NpfFormspay extends BaseModel
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
    public $created;
     
    /**
     *
     * @var string
     */
    public $domain_id;
     
    /**
     *
     * @var integer
     */
    public $form_name;
     
    /**
     *
     * @var integer
     */
    public $form_fields;

    /**
     *
     * @var string
     */
    public $useragent;

    /**
     *
     * @var string
     */
    public $userip;

    public function beforeCreate(){
        $this->created = $this->getDatetime();
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id',
            'created' => 'created',
            'domain_id' => 'domain_id',
            'form_name' => 'form_name', 
            'form_fields' => 'form_fields',
            'useragent' => 'useragent',
            'userip' => 'userip',
        );

    }

}