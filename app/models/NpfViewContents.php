<?php

namespace Vokuro\Models;

class NpfViewContents extends BaseModel
{

    /**
     *
     * @var int
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
    public $template_bn;
     
    /**
     *
     * @var string
     */
    public $template_en;
     
    /**
     *
     * @var string
     */
    public $header_bn;
     
    /**
     *
     * @var string
     */
    public $header_en;
     
    /**
     *
     * @var string
     */
    public $footer_bn;
     
    /**
     *
     * @var string
     */
    public $footer_en;
     
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
    public $is_pagination;
     
    /**
     *
     * @var string
     */
    public $is_more;
     
    /**
     *
     * @var string
     */
    public $more_link;
     
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
    public $domainpermissions;
     
    /**
     *
     * @var string
     */
    public $userpermissions;
     
    /**
     *
     * @var string
     */
    public $uploadpath;
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
            'template_bn' => 'template_bn', 
            'template_en' => 'template_en', 
            'header_bn' => 'header_bn', 
            'header_en' => 'header_en', 
            'footer_bn' => 'footer_bn', 
            'footer_en' => 'footer_en', 
            'sql_query' => 'sql_query',
            'css' => 'css',
            'js' => 'js',
            'is_pagination' => 'is_pagination', 
            'is_more' => 'is_more', 
            'more_link' => 'more_link', 
            'created' => 'created', 
            'lastmodified' => 'lastmodified', 
            'domainpermissions' => 'domainpermissions', 
            'userpermissions' => 'userpermissions',
            'active' => 'active',
            'is_right_side_bar' => 'is_right_side_bar',
            'uploadpath' => 'uploadpath',
        );
    }

}
