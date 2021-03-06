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
use Vokuro\Models\NpfDomainTypes;

class NpfDomainsForm extends Form
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

		$this->add(new Text('subdomain',array('class'=>'input-xxlarge')));
		$this->add(new Text('alias',array('class'=>'input-xxlarge')));

		$this->add(new Text('sitename_bn',array('class'=>'input-xxlarge')));
		$this->add(new Text('sitename_en',array('class'=>'input-xxlarge')));

        $this->add(new Text('external_link',array('class'=>'input-xxlarge')));
        $this->add(new Select('site_status', array(
            '1' => 'External Link',
            '2' => 'Moved In the portal',
            '3' => 'Moving in the portal',
            '4' => 'Currently have no site',
        )));

        $this->add(new Select('domain_type_id', NpfDomainTypes::find(), array(
            'using' => array('id', 'name'),
            'useEmpty' => true,
        )));

        $this->add(new Select('parent_id', NpfDomains::find("domain_type_id=2 AND active=1 ORDER BY sitename_bn"), array(
            'using' => array('id', 'sitename_bn'),
            'useEmpty' => true,
            'emptyText' => '',
            'emptyValue' => '0'
        )));

        $this->add(new Select('active', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
        $this->add(new Select('is_hosted', array(
            '1' => 'Yes',
            '0' => 'No'
        )));


//        $this->add(new Text('site_theme',array('class'=>'input-xxlarge')));
        $this->add(new Text('site_frontpage',array('class'=>'input-xxlarge')));

        $this->add(new Text('site_mail',array('class'=>'input-xxlarge')));
		$this->add(new Text('meta_description',array('class'=>'input-xxlarge')));
        $this->add(new Text('analytics_id',array('class'=>'input-xxlarge')));
        
        $this->add(new Text('site_slogan_bn',array('class'=>'input-xxlarge')));
        $this->add(new Text('site_slogan_en',array('class'=>'input-xxlarge')));

        $this->add(new Text('site_mission_bn',array('class'=>'input-xxlarge')));
        $this->add(new Text('site_mission_en',array('class'=>'input-xxlarge')));

        $this->add(new TextArea('site_footer_bn',array('class'=>'input-xxlarge ck-editor')));
        $this->add(new TextArea('site_footer_en',array('class'=>'input-xxlarge ck-editor')));

        $this->add(new Text('site_offline_message_bn',array('class'=>'input-xxlarge')));
        $this->add(new Text('site_offline_message_en',array('class'=>'input-xxlarge')));

        $this->add(new Text('template',array('class'=>'input')));

        $this->add(new Select('site_default_language', array(
            'bn' => 'Bangla',
            'en' => 'English'
        )));
        $this->add(new Select('site_offline', array(
            '0' => 'Site Offline',
            '1' => 'Site Online'
        )));

    }
}