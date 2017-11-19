<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class NpfMenus extends BaseModel
{

    /**
     *
     * @var string
     */
    public $id;
     
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
     * @var integer
     */
    public $parent_id;
     
    /**
     *
     * @var integer
     */
    public $menu_type_id;
     
    /**
     *
     * @var integer
     */
    public $menu_link_type_id;
     
    /**
     *
     * @var string
     */
    public $link_path;
    /**
     *
     * @var string
     */
    public $link_type;
     
    /**
     *
     * @var integer
     */
    public $active;
     
    /**
     *
     * @var integer
     */
    public $external;
     
    /**
     *
     * @var integer
     */
    public $has_children;
     
    /**
     *
     * @var integer
     */
    public $depth;
     
    /**
     *
     * @var integer
     */
    public $weight;
     
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
    public $router_path;
     
    /**
     *
     * @var integer
     */
    public $domain_id;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'title_bn' => 'title_bn', 
            'title_en' => 'title_en', 
            'parent_id' => 'parent_id', 
            'menu_type_id' => 'menu_type_id', 
            'menu_link_type_id' => 'menu_link_type_id', 
            'link_type' => 'link_type',
            'link_path' => 'link_path',
            'active' => 'active',
            'external' => 'external', 
            'has_children' => 'has_children', 
            'depth' => 'depth', 
            'weight' => 'weight', 
            'created' => 'created', 
            'lastmodified' => 'lastmodified', 
            'createdby' => 'createdby', 
            'lastmodifiedby' => 'lastmodifiedby', 
            'router_path' => 'router_path', 
            'domain_id' => 'domain_id'
        );
    }
    public static function getMenusByDomainId($did)
    {
        // A raw SQL statement

        $sql = "
                    SELECT
                        `id`,`title_bn`,`title_en`,`parent_id`,`link_type`,`link_path`,`router_path`,`external`,`has_children`,`depth`,`active`
                    FROM `npf_menus`
                    WHERE `domain_id` = $did
                    ORDER BY `depth`, `weight`
               ";

        // Base model
        $menus = new NpfMenus();

        // Execute the query
        return new Resultset(null, $menus, $menus->getReadConnection()->query($sql));
    }

}
