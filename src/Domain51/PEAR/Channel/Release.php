<?php

class Domain51_PEAR_Channel_Release
{
    private $_data = array();
    
    public function __construct(PDO $pdo, $id)
    {
        $query = "SELECT * FROM releases WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->execute(array(
            ':id' => $id
        ));
        $this->_data = $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    public function __get($key)
    {
        return $this->_data[$key];
    }
}