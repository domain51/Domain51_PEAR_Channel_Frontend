<?php

class Domain51_PEAR_Channel_ReleaseList extends Domain51_PEAR_Channel_AbstractIterator
{
    private $_raw_data = array();
    protected $_type = 'Release';
    
    public function __construct(Domain51_PEAR_Channel_Config $config, Domain51_PEAR_Channel_Package $package)
    {
        parent::__construct();
        
        $query = "SELECT * FROM releases WHERE package = :package AND channel = :channel";
        $statement = $config->pdo->prepare($query);
        $statement->execute(array(
            ':package' => (string)$package,
            ':channel' => (string)$package->channel,
        ));
        $this->_raw_data = $this->_data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->_config = $config;
    }
    
    public function filter($type)
    {
        $args = func_get_args();
        array_shift($args);
        array_unshift($args, $this->_raw_data);
        $filter_method = "_filter_{$type}";
        $this->_data = call_user_func_array(
            array($this, $filter_method),
            $args
        );
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
    
    protected function _filter_state(array $raw_data, $state)
    {
        $array = array();
        foreach ($raw_data as $release) {
            if ($release['state'] != $state) {
                continue;
            }
            
            $array[] = $release;
        }
        return $array;
    }
}