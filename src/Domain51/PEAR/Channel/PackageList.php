<?php

class Domain51_PEAR_Channel_PackageList implements Iterator
{
    private $_config = null;
    private $_data = null;
    
    public function __construct(Domain51_PEAR_Channel_Config $config, array $criteria = null)
    {
        $this->_config = $config;
        $where_sql = '';
        $real_criteria = array();
        if (is_array($criteria) && count($criteria) > 0) {
            $temp_criteria = array();
            foreach ($criteria as $key => $value) {
                $temp_criteria[] = "{$key} = :{$key}";
                $real_criteria[":{$key}"] = $value;
            }
            $where_sql = "WHERE " . implode(' AND ', $temp_criteria);
        }
        $statement = $config->pdo->prepare("SELECT * FROM packages {$where_sql}");
        $statement->execute($real_criteria);
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