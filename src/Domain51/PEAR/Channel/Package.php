<?php

class Domain51_PEAR_Channel_Package extends Domain51_PEAR_Channel_AbstractDBModel
{
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria)
    {
        if (!is_array($criteria)) {
            $criteria = array('package' => $criteria);
        }
        
        parent::__construct($config, $criteria);
    }
    
    /**
     * @todo add caching to all pseudo-properties
     */
    public function __get($key)
    {
        $value = parent::__get($key);
        if (!is_null($value)) {
            return $value;
        }
        
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
            
            case 'parentPackage' :
                try {
                    return new Domain51_PEAR_Channel_Package(
                        $this->_config,
                        $this->parent
                    );
                } catch (Domain51_PEAR_Channel_Package_NotFoundException $e) {
                    return false;
                }
        }
    }
    
    public function __toString()
    {
        return $this->package;
    }
}

class Domain51_PEAR_Channel_Package_NotFoundException extends PEAR_Exception { }
class Domain51_PEAR_Channel_Package_UnrecoverableException extends PEAR_Exception { }