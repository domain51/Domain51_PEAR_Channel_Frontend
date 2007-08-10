<?php

class Domain51_PEAR_Channel_Package
{
    private $_data = array();
    
    public function __construct($pdo, $criteria)
    {
        if (!is_array($criteria)) {
            $criteria = array('package' => $criteria);
        }
        $this->_init($pdo, $criteria);
    }
    
    private function _init(PDO $pdo, array $criteria) {
        $where = array();
        $final_criteria = array();
        foreach ($criteria as $column => $value) {
            $where[] = "{$column} = :{$column}";
            $final_critera[":{$column}"] = $value;
        }
        $query = "SELECT * FROM packages WHERE " . implode(' AND ', $where);
        $statement = $pdo->prepare($query);
        $statement->execute($final_critera);
        $this->_data = $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    public function __get($key)
    {
        return $this->_data[$key];
    }
}

class Domain51_PEAR_Channel_Package_NotFoundException extends PEAR_Exception { }
class Domain51_PEAR_Channel_Package_UnrecoverableException extends PEAR_Exception { }