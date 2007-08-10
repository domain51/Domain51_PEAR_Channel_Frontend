<?php

class Domain51_PEAR_Channel_Release
{
    private $_data = array();
    
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria)
    {
        if (!is_array($criteria)) {
            $criteria = array('id' => $criteria);
        }
        if (isset($criteria['_RAW_VALUES'])) {
            $this->_data = $criteria;
        } else {
            $this->_init($config->pdo, $criteria);
        }
    }
    
    private function _init(PDO $pdo, array $criteria) {
        $where = array();
        $final_criteria = array();
        foreach ($criteria as $column => $value) {
            $where[] = "{$column} = :{$column}";
            $final_critera[":{$column}"] = $value;
        }
        $query = "SELECT * FROM releases WHERE " . implode(' AND ', $where);
        $statement = $pdo->prepare($query);
        $statement->execute($final_critera);
        $this->_data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($this->_data === false){
            if (count($statement->errorInfo()) > 1) {
                throw new Domain51_PEAR_Channel_Release_UnrecoverableException(
                    "problem with query",
                    $statement->errorInfo()
                );
            }
            throw new Domain51_PEAR_Channel_Release_NotFoundException(
                'unable to locate release',
                $criteria
            );
        }
    }
    
    public function __get($key)
    {
        return $this->_data[$key];
    }
}

class Domain51_PEAR_Channel_Release_NotFoundException extends PEAR_Exception { }
class Domain51_PEAR_Channel_Release_UnrecoverableException extends PEAR_Exception { }