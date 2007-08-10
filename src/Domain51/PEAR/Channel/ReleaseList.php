<?php

class Domain51_PEAR_Channel_ReleaseList
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
    }
    
    public function count()
    {
        return count($this->_data);
    }
    
    public function filter($type)
    {
        $this->_data = array();
        switch ($type) {
            case 'latest' :
                foreach($this->_raw_data as $release) {
                    if (!isset($this->_data[$release['state']])) {
                        $this->_data[$release['state']] = $release;
                        continue;
                    }
                    
                    // one exists, see if this version is newer and replace if it is
                    if ($this->_data[$release['state']]['version'] < $release['version']) {
                        $this->_data[$release['state']] = $release;
                    }
                }
                break;
        }
    }
}