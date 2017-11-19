<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness,
    Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;


class NpfOffices extends Model

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
    public $name_bn;
     
    /**
     *
     * @var string
     */
    public $name_en;
     
    /**
     *
     * @var string
     */
    public $address_bn;
     
    /**
     *
     * @var string
     */
    public $address_en;
     
    /**
     *
     * @var string
     */
    public $phone;
     
    /**
     *
     * @var string
     */
    public $email;
     
    /**
     *
     * @var integer
     */
    public $domain_id;
     
    /**
     *
     * @var string
     */
    public $created;
     
    /**
     *
     * @var string
     */
    public $modified;
     
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
     
    /**
     * Validations and business logic
     */
    public function validation()
    {

        $this->validate(
            new Email(
                array(
                    "field"    => "email"
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'name_bn' => 'name_bn', 
            'name_en' => 'name_en', 
            'address_bn' => 'address_bn', 
            'address_en' => 'address_en', 
            'phone' => 'phone', 
            'email' => 'email', 
            'domain_id' => 'domain_id', 
            'created' => 'created', 
            'modified' => 'modified', 
            'createdby' => 'createdby', 
            'lastmodifiedby' => 'lastmodifiedby'
        );
    }
    public function initialize()
    {
        $this->hasMany("id", "Vokuro\Models\NpfOfficeUsers", "office_id", array(
            'alias' => 'npfusers'
        ));
        $this->belongsTo('domain_id', 'Vokuro\Models\NpfDomains', 'id', array(
            'alias' => 'npfdomains',
            'reusable' => true
        ));
    }
}
