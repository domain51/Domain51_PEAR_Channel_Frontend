<?php

class Domain51_PEAR_Channel_Dependency_enUS extends Domain51_PEAR_Channel_Dependency
{
    protected $_translated_type = array(
        'pkg' => 'Package',
        'ext' => 'PHP Extension',
        'php' => 'PHP',
        'prog' => 'Program',
        'ldlib' => 'Development Library',
        'rtlib' => 'Runtime Library',
        'os' => 'Operating System',
        'websrv' => 'Web Server',
        'sapi' => 'SAPI Backend',
    );
    
    protected $_translated_version = array(
        'has' => ' ',
        'lt' => ' older than %s ',
        'ge' => ' %s or newer ',
        'le' => ' %s or older ',
        'eq' => ' version %s ',
        'ne' => ' any version but %s ',
        'gt' => ' newer than %s ',
    );
}