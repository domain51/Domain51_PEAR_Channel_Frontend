<?php

class Domain51_PEAR_Channel_Config
{
    private $_data = array();
    
    public function __construct(array $data)
    {
        $this->_data = $data;
    }
    
    public function __get($key)
    {
        return $this->_data[$key];
    }
}