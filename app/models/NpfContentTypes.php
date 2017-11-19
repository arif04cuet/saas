<?php

namespace Vokuro\Models;


class NpfContentTypes extends BaseModel
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
    public $human_name;
     
    /**
     *
     * @var string
     */
    public $flds;
     
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
     * @var string
     */
    public $volt_template_bn;
    /**
     *
     * @var string
     */
    public $volt_template_en;

    /**
     *
     * @var string
     */
    public $sql_query;
    /**
     *
     * @var string
     */
    public $css;
    /**
     *
     * @var string
     */
    public $js;


    /**
     *
     * @var string
     */
    public $allow_domains;
    /**
     *
     * @var string
     */
    public $icon;
    /**
     *
     * @var string
     */
    public $list_fields;
    /**
     *
     * @var integer
     */
    public $active;
    /**
     *
     * @var integer
     */
    public $is_right_side_bar;
/**
     *
     * @var integer
     */
    public $use_title;
/**
     *
     * @var integer
     */
    public $use_body;
/**
     *
     * @var integer
     */
    public $is_common;
    /**
     *
     * @var integer
     */
    public $domain_id;

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
            'human_name' => 'human_name', 
            'flds' => 'flds', 
            'created' => 'created', 
            'lastmodified' => 'lastmodified', 
            'volt_template_bn' => 'volt_template_bn',
            'volt_template_en' => 'volt_template_en',
            'sql_query' => 'sql_query',
            'css' => 'css',
            'js' => 'js',
            'active' => 'active',
            'use_title' => 'use_title',
            'use_body' => 'use_body',
            'is_common' => 'is_common',
            'domain_id' => 'domain_id',
            'is_right_side_bar' => 'is_right_side_bar',
            'allow_domains' => 'allow_domains',
            'list_fields' => 'list_fields',
            'icon' => 'icon',
        );
    }

}
