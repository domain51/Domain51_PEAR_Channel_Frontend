<?php

class Domain51_PEAR_Channel_ReleaseList implements Iterator
{
    private $_config = null;
    private $_raw_data = array();
    private $_data = array();
    
    public function __construct(Domain51_PEAR_Channel_Config $config, Domain51_PEAR_Channel_Package $package)
    {
        $query = "SELECT * FROM releases WHERE package = :package AND channel = :channel";
        $statement = $config->pdo->prepare($query);
        $statement->execute(array(
            ':package' => (string)$package,
            ':channel' => (string)$package->channel,
        ));
        $this->_raw_data = $this->_data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->_config = $config;
    }
    
    public function count()
    {
        return count($this->_data);
    }
    
    public function current()
    {
        $data = current($this->_data);
        $data['_RAW_VALUES'] = true;
        return new Domain51_PEAR_Channel_Release(
            $this->_config,
            $data
        );
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
    
    public function filter($type)
    {
        $filter_method = "_filter_{$type}";
        $this->_data = $this->$filter_method($this->_raw_data);
    }
    
    protected function _filter_latest(array $raw_data)
    {
        $array = array();
        foreach($raw_data as $release) {
            if (!isset($array[$release['state']])) {
                $array[$release['state']] = $release;
                continue;
            }
            
            // one exists, see if this version is newer and replace if it is
            if ($array[$release['state']]['version'] < $release['version']) {
                $array[$release['state']] = $release;
            }
        }
        return $array;
    }
}