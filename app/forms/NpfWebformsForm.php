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

use Vokuro\Models\NpfWebforms;

class NpfWebformsForm extends Form
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
        $this->add(new Text('machine_name',array('class'=>'input-xxlarge')));
		$this->add(new Text('form_title',array('class'=>'input-xxlarge')));

        $this->add(new Select('action_type', array(
            'get' => 'Get',
            'post' => 'Post'
        )));

		$this->add(new Text('action_path',array('class'=>'input-xxlarge')));
        $this->add(new Text('form_msg',array('class'=>'input-xxlarge')));
        $this->add(new Text('form_email',array('class'=>'input-xxlarge')));

        $this->add(new Select('active', array(
            '1' => 'Yes',
            '0' => 'No'
        )));

        $this->add(new TextArea('header_bn',array('class'=>'input-xxlarge ck-editor')));
        $this->add(new TextArea('header_en',array('class'=>'input-xxlarge ck-editor')));

        $this->add(new TextArea('footer_bn',array('class'=>'input-xxlarge ck-editor')));
        $this->add(new TextArea('footer_en',array('class'=>'input-xxlarge ck-editor')));

    }
}