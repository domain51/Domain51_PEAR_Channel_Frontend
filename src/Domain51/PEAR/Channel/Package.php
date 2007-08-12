<?php

class Domain51_PEAR_Channel_Package
{
    private $_config = null;
    private $_data = array();
    
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria)
    {
        $this->_config = $config;
        if (!is_array($criteria)) {
            $criteria = array('package' => $criteria);
        }
        if (!isset($criteria['channel'])) {
            $criteria['channel'] = $config->channel;
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
        $query = "SELECT * FROM packages WHERE " . implode(' AND ', $where);
        $statement = $pdo->prepare($query);
        $statement->execute($final_critera);
        $this->_data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($this->_data === false) {
            $error = $statement->errorInfo();
            if (count($error) > 1) {
                throw new Domain51_PEAR_Channel_Package_UnrecoverableException(
                    'problem with query',
                    $error
                );
            }
            
            throw new Domain51_PEAR_Channel_Package_NotFoundException(
                'unable to find matching package',
                $criteria
            );
        }
    }
    
    /**
     * @todo add caching to all pseudo-properties
     */
    public function __get($key)
    {
        switch ($key) {
            case 'releases' :
                return new Domain51_PEAR_Channel_ReleaseList($this->_config, $this);
            
            case 'has_children' :
                $statement = $this->_config->pdo->prepare("SELECT COUNT(*) FROM packages WHERE parent = :package");
                $statement->execute(array(
                    ':package' => (string)$this->package,
                ));
                return $statement->fetchColumn() > 0;
            
            case 'childPackages' :
                return new Domain51_PEAR_Channel_PackageList(
                    $this->_config,
                    array('parent' => (string)$this->package)
                );
            
            default:
                return $this->_data[$key];
        }
    }
    
    public function __toString()
    {
        return $this->package;
    }
}

class Domain51_PEAR_Channel_Package_NotFoundException extends PEAR_Exception { }
class Domain51_PEAR_Channel_Package_UnrecoverableException extends PEAR_Exception { }