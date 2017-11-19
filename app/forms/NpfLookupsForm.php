<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\TextArea,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Forms\Element\Password,
	Phalcon\Forms\Element\Submit,
	Phalcon\Forms\Element\Select,
	Phalcon\Forms\Element\Check,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email;

use Vokuro\Models\NpfLookupTypes;
use Vokuro\Models\NpfDomainResources;

class NpfLookupsForm extends Form
{

	public function initialize($entity=null, $options=null)
	{

		//In edition the id is hidden
		if (isset($options['edit']) && $options['edit']) {
			$id = new Hidden('id');
		} else {
			$id = new Text('id');
		}

		$this->add($id);

		$this->add(new Text('weight',array('class'=>'input')));

		$this->add(new Text('name_bn',array('class'=>'input-xxlarge')));
		$this->add(new Text('name_en',array('class'=>'input-xxlarge')));

        $domainid = $this->auth->getIdentity();
//        var_dump($domainid);
        $domainid = $domainid['domain_id'];
        if($domainid==1){
            $this->add(new Select('lookuptype_id', NpfLookupTypes::find(), array(
                'using' => array('id', 'name'),
                'useEmpty' => true,
            )));
        }else{
            $cnt_ids = $this->getDomainTaxonomy($domainid);
            $this->add(new Select('lookuptype_id', NpfLookupTypes::find(" is_common=0 AND active = 1 AND id IN (".$cnt_ids.")"), array(
                'using' => array('id', 'name'),
                'useEmpty' => true,
            )));
        }
//        $this->add(new Select('lookuptype_id', NpfLookupTypes::find(), array(
//        'using' => array('id', 'name'),
//        'useEmpty' => true,
//        )));


    }
    private function getDomainTaxonomy($domainid){
        $cnt_ids = NpfDomainResources::findFirst("domain_id = '$domainid'");
        if($cnt_ids){
            return $cnt_ids->taxonomy_ids;
        }
        return '';
    }
}