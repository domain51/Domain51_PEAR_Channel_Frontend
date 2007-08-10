<?php

class Domain51_PEAR_Channel_Factory
{
    private $_config = null;
    
    public function __construct($config)
    {
        $this->_config = $config;
    }
    
    public function loadReleaseByVersion($name, $version)
    {
        return new Domain51_PEAR_Channel_Release(
            $this->_config,
            array(
                'package' => (string)$name,
                'version' => $version,
            )
        );
    }
}