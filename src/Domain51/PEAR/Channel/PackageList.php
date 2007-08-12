<?php

class Domain51_PEAR_Channel_PackageList extends Domain51_PEAR_Channel_AbstractIterator
{
    protected $_type = 'Package';
    public function __construct(Domain51_PEAR_Channel_Config $config, array $criteria = null)
    {
        parent::__construct();
        
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
}