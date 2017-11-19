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


use Vokuro\Models\NpfDomains;
use Vokuro\Models\Users;

class NpfOfficesForm extends Form
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

		$this->add(new Text('name_bn',array('class'=>'input-xxlarge')));
		$this->add(new Text('name_en',array('class'=>'input-xxlarge')));

		$this->add(new Text('address_bn',array('class'=>'input-xxlarge')));
		$this->add(new Text('address_en',array('class'=>'input-xxlarge')));

		$this->add(new Text('phone',array('class'=>'input-xxlarge')));
		$this->add(new Text('email',array('class'=>'input-xxlarge')));

        $this->add(new Select('domain_id', NpfDomains::find(), array(
            'using' => array('id', 'sitename_bn'),
            'useEmpty' => true,
        )));
        $this->add(new Select('user_id', Users::find(), array(
            'using' => array('id', 'email'),
            'useEmpty' => true,
        )));


    }
}