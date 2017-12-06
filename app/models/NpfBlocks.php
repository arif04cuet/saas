<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;


class NpfBlocks extends BaseModel
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
    public $body_bn;
    /**
     *
     * @var string
     */
    public $body_en;
     
    /**
     *
     * @var integer
     */
    public $domain_id;
    /**
     *
     * @var string
     */
    public $more;
    /**
     *
     * @var string
     */
    public $uploadpath;

    /**
     *
     * @var integer
     */
    public $template_block_name;

    /**
     *
     * @var integer
     */
    public $weight;
     
    /**
     *
     * @var integer
     */
    public $region_id;



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
            'id' => 'id', 
            'title_bn' => 'title_bn',
            'title_en' => 'title_en',
            'body_bn' => 'body_bn',
            'body_en' => 'body_en',
            'domain_id' => 'domain_id',
            'template_block_name' => 'template_block_name',
            'weight' => 'weight',
            'region_id' => 'region_id', 
            'more' => 'more',
            'uploadpath' => 'uploadpath',
            'created' => 'created',
            'lastmodified' => 'lastmodified', 
            'createdby' => 'createdby',
            'lastmodifiedby' => 'lastmodifiedby',
        );
    }

    public static function updateBlock($id, $region, $weight){
        // A raw SQL statement
        $sql = "UPDATE npf_blocks
                SET
                  weight = $weight,
                  region_id = $region
                WHERE id = $id
                ";
        echo $sql;
        // Base model
        $blocks = new NpfBlocks();

        // Execute the query
        return new Resultset(null, $blocks, $blocks->getReadConnection()->query($sql));
    }
}
