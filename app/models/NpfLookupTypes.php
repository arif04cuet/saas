<?php
namespace Vokuro\Models;

class NpfLookupTypes extends BaseModel
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
    public $description;

    /**
     *
     * @var integer
     */
    public $lookuptype_id;

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
    public $active;
    /**
     *
     * @var integer
     */
    public $is_common;

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
            'description' => 'description',
            'lookuptype_id' => 'lookuptype_id',
            'created' => 'created',
            'lastmodified' => 'lastmodified',
            'active' => 'active',
            'is_common' => 'is_common',
        );
    }

}
