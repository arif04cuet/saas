<?php


namespace Vokuro\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Submit,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Identical,
	Phalcon\Validation\Validator\Email;

use Vokuro\Models\Profiles;


class ForgotPasswordForm extends Form
{

	public function initialize()
	{
		$email = new Text('email', array(
			'placeholder' => 'Email'
		));

		$email->addValidators(array(
			new PresenceOf(array(
				'message' => 'The e-mail is required'
			)),
			new Email(array(
				'message' => 'The e-mail is not valid'
			))
		));

		$this->add($email);


		//CSRF
		$csrf = new Hidden('csrf');

		$csrf->addValidator(
			new Identical(array(
				'value' => $this->security->getSessionToken(),
				'message' => 'CSRF validation failed'
			))
		);

		$this->add($csrf);

		$this->add(new Submit('Send', array(
			'class' => 'btn btn-primary'
		)));
	}

}