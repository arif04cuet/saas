<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;


class NpfDomainTypes extends Model
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
    public $parent_id;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'name' => 'name', 
            'created' => 'created', 
            'modified' => 'modified', 
            'parent_id' => 'parent_id'
        );
    }

    public function initialize()
    {

        $this->belongsTo('parent_id', 'Vokuro\Models\NpfDomainTypes', 'id', array(
            'alias' => 'npfdomaintypes',
            'reusable' => true
        ));

    }

}
