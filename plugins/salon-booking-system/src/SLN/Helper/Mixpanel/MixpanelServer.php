<?php

require_once __DIR__ . '/../../Third/mixpanel/vendor/autoload.php';

class SLN_Helper_Mixpanel_MixpanelServer
{
    protected $mp;

    public function __construct($token)
    {
        $this->mp = Mixpanel::getInstance($token, array(
            'debug'           => true,
            'use_ssl'         => true,
            'timeout'         => 3,
            'connect_timeout' => 3,
        ));
    }

    public function track($event, $data = array())
    {
        // track an event
        $this->mp->track($event, $data);
    }
}
