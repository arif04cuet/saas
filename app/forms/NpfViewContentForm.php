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


class NpfViewContentForm extends Form
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

		if (isset($options['edit']) && $options['edit']) {
			$name = new Text('name',array('class'=>'input-xxlarge','readonly'=>'readonly'));
		} else {
			$name = new Text('name',array('class'=>'input-xxlarge'));
		}
		$this->add($name);

		$this->add(new Text('human_name',array('class'=>'input-xxlarge')));

		$this->add(new TextArea('template_bn',array('class'=>'input-xxlarge','rows'=>'10')));
		$this->add(new TextArea('template_en',array('class'=>'input-xxlarge','rows'=>'10')));

        $this->add(new TextArea('sql_query',array('class'=>'input-xxlarge','rows'=>'10')));

        $this->add(new TextArea('css',array('class'=>'input-xxlarge','rows'=>'10')));
        $this->add(new TextArea('js',array('class'=>'input-xxlarge','rows'=>'10')));

        $this->add(new TextArea('header_bn',array('class'=>'input-xxlarge ck-editor')));
        $this->add(new TextArea('header_en',array('class'=>'input-xxlarge ck-editor')));
        $this->add(new TextArea('footer_bn',array('class'=>'input-xxlarge ck-editor')));
        $this->add(new TextArea('footer_en',array('class'=>'input-xxlarge ck-editor')));



        $this->add(new Select('active', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
        $this->add(new Select('is_right_side_bar', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
        $this->add(new Select('is_pagination', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
    }
}