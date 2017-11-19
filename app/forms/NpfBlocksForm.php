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
use Vokuro\Models\NpfTemplateBlocks;

class NpfBlocksForm extends Form
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

		$this->add(new Text('title_bn',array('class'=>'input-xxlarge')));
		$this->add(new Text('title_en',array('class'=>'input-xxlarge')));

		$this->add(new TextArea('body_bn',array('class'=>'ck-editor')));
		$this->add(new TextArea('body_en',array('class'=>'ck-editor')));

        $this->add(new Text('more',array('class'=>'input-xxlarge')));

//        $this->add(new Select('is_template_block', array(
//            '1' => 'Yes',
//            '0' => 'No'
//        )));

        $this->add(new Select('template_block_name', NpfTemplateBlocks::find(), array(
            'using' => array('name', 'name'),
            'useEmpty' => true,
        )));
    }
}