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

use Vokuro\Models\Contents;

class ContentTypeForm extends Form
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


        $this->add(new Text('human_name',array('class'=>'input-xxlarge')));

        $this->add(new TextArea('volt_template_bn',array('class'=>'input-xxlarge','rows'=>'10')));
        $this->add(new TextArea('volt_template_en',array('class'=>'input-xxlarge','rows'=>'10')));

        $this->add(new TextArea('css',array('class'=>'input-xxlarge','rows'=>'10')));
        $this->add(new TextArea('js',array('class'=>'input-xxlarge','rows'=>'10')));
        $this->add(new Text('icon',array('class'=>'input-large')));
        $this->add(new Select('active', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
        $this->add(new Select('is_right_side_bar', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
        $this->add(new Select('use_title', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
        $this->add(new Select('use_body', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
        $this->add(new Select('is_common', array(
            '1' => 'Yes',
            '0' => 'No'
        )));

        $attr = Contents::get_sys_fld_type_names();

//        $this->add(new Select('fld_tmp', $attr, $attr));

    }

}