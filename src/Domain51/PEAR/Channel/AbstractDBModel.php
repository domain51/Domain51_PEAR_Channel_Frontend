<?php

abstract class Domain51_PEAR_Channel_AbstractDBModel
{
    protected $_config = null;
    protected $_data = array();
    protected $_table = '';
    
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria)
    {
        $this->_config = $config;
        if (!isset($criteria['channel'])) {
            $criteria['channel'] = $config->channel;
        }
        
        if (isset($criteria['_RAW_VALUES'])) {
            $this->_data = $criteria;
        } else {
            if (empty($this->_table)) {
                $exploded = explode('_', get_class($this));
                $this->_table = strtolower(array_pop($exploded)) . 's';
            }
            $this->_init($config->pdo, $criteria);
        }
    }
    
    private function _init(PDO $pdo, array $criteria) {
        $where = array();
        $final_criteria = array();
        foreach ($criteria as $column => $value) {
            $where[] = "{$column} = :{$column}";
            $final_criteria[":{$column}"] = $value;
        }
        $query = "SELECT * FROM {$this->_table} WHERE " . implode(' AND ', $where);
        $statement = $pdo->prepare($query);
        $statement->execute($final_criteria);
        $this->_data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($this->_data === false) {
            $error = $statement->errorInfo();
            if (count($error) > 1) {
                $exception = get_class($this) . "_UnrecoverableException";
                throw new $exception(
                    'problem with query',
                    $error
                );
            }
            
            $exception = get_class($this) . "_NotFoundException";
            $exploded = explode('_', get_class($this));
            $type = strtolower(array_pop($exploded));
            throw new $exception(
                'unable to locate ' . $type,
                $criteria
            );
        }
    }
    
    public function __get($key)
    {
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        }
    }
}