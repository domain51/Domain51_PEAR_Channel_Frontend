<?php

class Domain51_PEAR_Channel_Maintainer extends Domain51_PEAR_Channel_AbstractDBModel
{
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria)
    {
        parent::__construct($config, $criteria);
    }
    
    public function __get($key)
    {
        switch ($key) {
            case 'package' :
                return new Domain51_PEAR_Channel_Package(
                    $this->_config,
                    array(
                        'package' => $this->_data['package'],
                        'channel' => $this->_data['channel'],
                    )
                );
            
            case 'handle' :
                return new Domain51_PEAR_Channel_Handle(
                    $this->_config,
                    $this->_data['handle']
                );
            
            default :
                return parent::__get($key);
        }
    }
}