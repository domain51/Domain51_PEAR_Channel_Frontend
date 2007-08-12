<?php

class Domain51_PEAR_Channel_PackageList implements Iterator
{
    private $_config = null;
    private $_data = null;
    
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria = null)
    {
        $this->_config = $config;
        $where_sql = '';
        $statement = $config->pdo->prepare("SELECT * FROM packages {$where_sql}");
        $statement->execute();
        $this->_data = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function count()
    {
        return count($this->_data);
    }
    
    public function current()
    {
        $data = current($this->_data);
        $data['_RAW_VALUES'] = true;
        return new Domain51_PEAR_Channel_Package($this->_config, $data);
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