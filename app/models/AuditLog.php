<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Vokuro\Models\NpfDomains;
class AuditLog extends BaseModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $user_id;

    /**
     * @var integer
     */
    public $domain_id;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     *
     * @var string
     */
    public $changes;


    /**
     *
     * @var integer
     */
    public $change_time;

    public function initialize()
    {
        $this->change_time = $this->getDatetime();
        $this->belongsTo('user_id', 'Vokuro\Models\Users', 'id', array(
            'alias' => 'user'
        ));
    }

    public function getSource()
    {
        return "audit_log";
    }

    public function getDomainName()
    {
        return NpfDomains::findFirstById($this->domain_id);
    }
}