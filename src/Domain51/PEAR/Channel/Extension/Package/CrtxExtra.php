<?php

class Domain51_PEAR_Channel_Extension_Package_CrtxExtra
    extends Domain51_PEAR_Channel_AbstractDBModel
    implements Domain51_PEAR_Channel_Extension
{
    protected $_table = 'package_extras';
    
    public function __construct(Domain51_PEAR_Channel_Config $config, Domain51_PEAR_Channel_Package $package)
    {
        $criteria = array(
            'channel' => (string)$package->channel,
            'package' => (string)$package->package,
        );
        parent::__construct($config, $criteria);
        
        // convert to bools
        $this->_data['qa_approval'] = (bool)$this->_data['qa_approval'];
        $this->_data['unit_tested'] = (bool)$this->_data['unit_tested'];
    }
    
    public function declaredProperties()
    {
        return array(
            'cvs_uri',
            'bugs_uri',
            'docs_uri',
            'qa_approval',
            'unit_tested',
        );
    }
}

class Domain51_PEAR_Channel_Extension_Package_CrtxExtra_NotFoundException extends PEAR_Exception { }
class Domain51_PEAR_Channel_Extension_Package_CrtxExtra_UnrecoverableException extends PEAR_Exception { }