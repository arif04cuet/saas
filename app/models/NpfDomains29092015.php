<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;


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
     * @var string
     */
    public $last_content_updated;

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
     * @var integer
     */
    public $site_status;

    /**
     *
     * @var string
     */
    public $external_link;

    /**
     *
     * @var string
     */
    public $site_mail;

    /**
     *
     * @var string
     */
    public $site_slogan_bn;

    /**
     *
     * @var string
     */
    public $site_slogan_en;

    /**
     *
     * @var string
     */
    public $site_footer_bn;

    /**
     *
     * @var string
     */
    public $site_footer_en;

    /**
     *
     * @var string
     */
    public $site_theme;

    /**
     *
     * @var string
     */
    public $site_default_language;

    /**
     *
     * @var string
     */
    public $site_frontpage;

    /**
     *
     * @var integer
     */
    public $site_offline;

    /**
     *
     * @var string
     */
    public $site_mission_bn;

    /**
     *
     * @var string
     */
    public $site_mission_en;
    /**
     *
     * @var integer
     */
    public $is_hosted;
    /**
     *
     * @var string
     */
    public $template;
    /**
     *
     * @var string
     */
    public $alias;

    /**
     *
     * @var integer
     */
    public $weight;

    /**
     *
     * @var string
     */
    public $analytics_id;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'subdomain' => 'subdomain',
            'last_content_updated' => 'last_content_updated',
            'domain_type_id' => 'domain_type_id',
            'parent_id' => 'parent_id',
            'active' => 'active',
            'sitename_bn' => 'sitename_bn',
            'sitename_en' => 'sitename_en',
            'site_conf' => 'site_conf',
            'site_status' => 'site_status',
            'external_link' => 'external_link',
            'created' => 'created',
            'lastmodified' => 'lastmodified',
            'createdby' => 'createdby',
            'lastmodifiedby' => 'lastmodifiedby',
            'site_mail' => 'site_mail',
            'site_slogan_bn' => 'site_slogan_bn',
            'site_slogan_en' => 'site_slogan_en',
            'site_footer_bn' => 'site_footer_bn',
            'site_footer_en' => 'site_footer_en',
            'site_theme' => 'site_theme',
            'site_default_language' => 'site_default_language',
            'site_frontpage' => 'site_frontpage',
            'site_offline' => 'site_offline',
            'site_mission_bn' => 'site_mission_bn',
            'is_hosted' => 'is_hosted',
            'template' => 'template',
            'alias' => 'alias',
            'site_mission_en' => 'site_mission_en',
            'weight' => 'weight',
            'analytics_id' => 'analytics_id'
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
