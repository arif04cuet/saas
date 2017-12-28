<?php

namespace Vokuro\Plugins;

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;

use Vokuro\Models\NpfDomains;

class Security extends Plugin
{

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        if(!isset($this->current_domain)){
            
            $requestedDomain = $this->request->getServer("HTTP_HOST");
            $domain = NpfDomains::findFirst("subdomain = '" . $requestedDomain . "'");
            $this->getDi()->set('current_domain',$domain);
        }
    }

}