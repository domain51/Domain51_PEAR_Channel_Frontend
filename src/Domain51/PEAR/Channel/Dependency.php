<?php

abstract class Domain51_PEAR_Channel_Dependency
{
    private $_config = null;
    private $_data = array();
    
    public function __construct(Domain51_PEAR_Channel_Config $config, array $data)
    {
        $this->_config = $config;
        $this->_data = $data;
        if (!isset($this->_data['version'])) {
            $this->_data['version'] = '';
        }
    }
    
    public function __toString()
    {
        return trim(sprintf(
            '%s:%s%s%s',
            $this->_translated_type[$this->_data['type']],
            $this->_getName(),
            sprintf(
                $this->_translated_version[$this->_data['rel']],
                $this->_data['version']
            ),
            $this->_getChannel()
        ));
    }
    
    private function _getName()
    {
        return (!empty($this->_data['name']) ? ' ' . $this->_data['name'] : '');
    }
    
    public function _getChannel()
    {
        return (!empty($this->_data['channel']) && $this->_data['channel'] != $this->_config->channel) ?
            'from ' . $this->_data['channel'] :
            '';
    }
}