<?php

class Domain51_PEAR_Channel_Package extends Domain51_PEAR_Channel_AbstractDBModel
{
    private $_extensions = array();
    private $_property_map = array();
    
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
        
        // check extensions
        if (isset($this->_property_map[$key])) {
            return $this->_extensions[$this->_property_map[$key]]->$key;
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
            
            case 'maintainers' :
                return new Domain51_PEAR_Channel_MaintainerList(
                    $this->_config,
                    array(
                        'channel' => (string)$this->_data['channel'],
                        'package' => (string)$this->_data['package'],
                    )
                );
        }
    }
    
    public function __toString()
    {
        return $this->package;
    }
    
    public function registerExtension(Domain51_PEAR_Channel_Extension $extension)
    {
        $extension_name = get_class($extension);
        $this->_extensions[$extension_name] = $extension;
        foreach ($extension->declaredProperties() as $property) {
            $this->_property_map[$property] = $extension_name;
        }
    }
    
    public function autoRegister($prefix = 'Domain51_PEAR_Channel_Extension_Package_', $base_path = null)
    {
        if (is_null($base_path)) {
            $base_path = dirname(__FILE__) . '/Extension/Package';
        }
        $files = scandir($base_path);
        foreach ($files as $file) {
            if (substr($file, 0, 1) == '.') {
                continue;
            }
            $extension = $prefix . substr($file, 0, -4);
            if (!isset($this->_extensions[$extension])) {
                $this->registerExtension(new $extension($this->_config, $this));
            }
        }
    }
}

class Domain51_PEAR_Channel_Package_NotFoundException extends PEAR_Exception { }
class Domain51_PEAR_Channel_Package_UnrecoverableException extends PEAR_Exception { }