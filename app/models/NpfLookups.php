<?php
namespace Vokuro\Models;

class NpfLookups extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;
    /**
     *
     * @var integer
     */
    public $domain_id;

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
     * @var integer
     */
    public $weight;
     
    /**
     *
     * @var integer
     */
    public $looktype_id;
      /**
     *
     * @var integer
     */
    public $parent_id;
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
    public $created;
     
    /**
     *
     * @var string
     */
    public $lastmodified;
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
            'domain_id' => 'domain_id',
            'name_bn' => 'name_bn',
            'name_en' => 'name_en', 
            'weight' => 'weight',
            'lookuptype_id' => 'lookuptype_id',
            'parent_id' => 'parent_id',
            'created' => 'created',
            'lastmodified' => 'lastmodified',
            'createdby' => 'createdby',
            'lastmodifiedby' => 'lastmodifiedby',
        );
    }
    public function initialize()
    {

        $this->belongsTo('lookuptype_id', 'Vokuro\Models\NpfLookupTypes', 'id', array(
            'alias' => 'npflookuptypes',
            'reusable' => true
        ));

    }
}
