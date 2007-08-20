<?php

class Domain51_PEAR_Channel_Release extends Domain51_PEAR_Channel_AbstractDBModel
{
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria)
    {
        if (!is_array($criteria)) {
            $criteria = array('id' => $criteria);
        }
        parent::__construct($config, $criteria);
        
        $this->_initDependencies();
    }
    
    private function _initDependencies()
    {
        $this->_data['dependencies'] = array();
        if (($deps = unserialize($this->deps)) === false) {
            return;
        }
        
        $dependency_object = 'Domain51_PEAR_Channel_Dependency_' . $this->_config->locale;
        foreach ($deps as $dep_data) {
            $this->_data['dependencies'][] = new $dependency_object($this->_config, $dep_data);
        }
    }
}

class Domain51_PEAR_Channel_Release_NotFoundException extends PEAR_Exception { }
class Domain51_PEAR_Channel_Release_UnrecoverableException extends PEAR_Exception { }