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

class NpfLookupTypesForm extends Form
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

		$this->add(new Text('name',array('class'=>'input-xxlarge')));
		$this->add(new Text('description',array('class'=>'input-xxlarge')));
        $domainid = $this->auth->getIdentity();
//        var_dump($domainid);
        $domainid = $domainid['domain_id'];
        if($domainid==1){
            $this->add(new Select('lookuptype_id', NpfLookupTypes::find(), array(
                'using' => array('id', 'name'),
                'useEmpty' => true,
            )));
        }else{
            $this->add(new Select('lookuptype_id', NpfLookupTypes::find('is_common=0'), array(
                'using' => array('id', 'name'),
                'useEmpty' => true,
            )));
        }
        $this->add(new Select('is_common', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
    }
}