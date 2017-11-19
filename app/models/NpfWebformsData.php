<?php

namespace Vokuro\Models;

class NpfWebformsData extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $forms_domain_id;
    /**
     *
     * @var string
     */
    public $machine_name;

    /**
     *
     * @var string
     */
    public $form_fields;

    public function getFields()
    {
        return unserialize(base64_decode($this->form_fields));
    }
}
