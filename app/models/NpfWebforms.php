<?php

namespace Vokuro\Models;

class NpfWebforms extends BaseModel
{
//npf_webforms

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $forms_domain_id;
    /**
     *
     * @var string
     */
    public $machine_name;
    /**
     *
     * @var integer
     */
    public $active;

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
    public $form_title;


    /**
     *
     * @var string
     */
    public $form_fields;

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
    public $action_type;

    /**
     *
     * @var string
     */
    public $action_path;

    /**
     *
     * @var string
     */
    public $form_msg;

    /**
     *
     * @var string
     */
    public $form_email;

    public function beforeCreate()
    {
        $this->created = $this->getDatetime();
        $this->lastmodified = $this->getDatetime();
        $this->action_type = '';
        $this->action_path = '';
    }

    public function beforeUpdate()
    {
        $this->lastmodified = $this->getDatetime();
        $this->action_type = '';
        $this->action_path = '';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'forms_domain_id' => 'forms_domain_id',
            'machine_name' => 'machine_name',
            'active' => 'active',
            'created' => 'created',
            'lastmodified' => 'lastmodified',
            'createdby' => 'createdby',
            'lastmodifiedby' => 'lastmodifiedby',
            'form_title' => 'form_title',
            'form_fields' => 'form_fields',
            'header_bn' => 'header_bn',
            'header_en' => 'header_en',
            'footer_bn' => 'footer_bn',
            'footer_en' => 'footer_en',
            'action_type' => 'action_type',
            'action_path' => 'action_path',
            'form_msg' => 'form_msg',
            'form_email' => 'form_email'
        );

    }

}

//SELECT `id`, `forms_domain_id`, `machine_name`, `active`, `created`, `lastmodified`, `createdby`, `lastmodifiedby`,
//`form_title`, `form_fields`, `header_bn`, `header_en`, `footer_bn`, `footer_en`, `action_type`, `action_path`
//FROM `npf_webforms` WHERE 1