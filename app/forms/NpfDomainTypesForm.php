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


use Vokuro\Models\NpfDomainTypes;

class NpfDomainTypesForm extends Form
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

        $this->add(new Select('parent_id', NpfDomainTypes::find(), array(
            'using' => array('id', 'name'),
            'useEmpty' => true,
        )));


    }
}