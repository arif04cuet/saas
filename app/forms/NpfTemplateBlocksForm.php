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

class NpfTemplateBlocksForm extends Form
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

        $this->add(new Text('title_bn',array('class'=>'input-xxlarge')));
        $this->add(new Text('title_en',array('class'=>'input-xxlarge')));

        $this->add(new Text('sql',array('class'=>'input-xxlarge')));

        $this->add(new TextArea('volt_bn',array('class'=>'input-xxlarge')));
        $this->add(new TextArea('volt_en',array('class'=>'input-xxlarge')));
        $this->add(new TextArea('js',array('class'=>'input-xxlarge')));
        $this->add(new TextArea('css',array('class'=>'input-xxlarge')));


    }
}