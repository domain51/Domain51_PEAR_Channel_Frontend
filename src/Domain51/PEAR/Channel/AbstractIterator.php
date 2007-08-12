<?php

abstract class Domain51_PEAR_Channel_AbstractIterator implements Iterator
{
    protected $_data = array();
    protected $_config = null;
    protected $_type;
    
    /**
     * @todo add test for a set _type property and throw exception if empty
     */
    public function __construct()
    {
        $this->_type = "Domain51_PEAR_Channel_{$this->_type}";
    }
    
    public function count()
    {
        return count($this->_data);
    }
    
    public function current()
    {
        $data = current($this->_data);
        $data['_RAW_VALUES'] = true;
        return new $this->_type($this->_config, $data);
    }
    
    public function key()
    {
        return key($this->_data);
    }
    
    public function next()
    {
        next($this->_data);
    }
    
    public function rewind()
    {
        reset($this->_data);
    }
    
    public function valid()
    {
        return current($this->_data) !== false;
    }
}