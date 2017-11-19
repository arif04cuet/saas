<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;


class NpfDomains extends Model
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
    public $subdomain;
     
    /**
     *
     * @var integer
     */
    public $domain_type_id;
     

    /**
     *
     * @var integer
     */
    public $parent_id;
     
    /**
     *
     * @var integer
     */
    public $active;
     
    /**
     *
     * @var string
     */
    public $sitename_bn;
     
    /**
     *
     * @var string
     */
    public $sitename_en;
     
    /**
     *
     * @var string
     */
    public $site_conf;
     
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
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'subdomain' => 'subdomain', 
            'domain_type_id' => 'domain_type_id', 
            'parent_id' => 'parent_id',
            'active' => 'active', 
            'sitename_bn' => 'sitename_bn', 
            'sitename_en' => 'sitename_en', 
            'site_conf' => 'site_conf', 
            'created' => 'created', 
            'lastmodified' => 'lastmodified', 
            'createdby' => 'createdby', 
            'lastmodifiedby' => 'lastmodifiedby', 
            'name_bn' => 'name_bn',
            'name_en' => 'name_en'
        );
    }

    public function initialize()
    {

        $this->belongsTo('domain_type_id', 'Vokuro\Models\NpfDomainTypes', 'id', array(
            'alias' => 'npfdomaintypes',
            'reusable' => true
        ));

    }

}
