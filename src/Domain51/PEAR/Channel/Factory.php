<?php

class Domain51_PEAR_Channel_Factory
{
    private $_pdo = null;
    
    public function __construct(PDO $pdo)
    {
        $this->_pdo = $pdo;
    }
    
    public function loadReleaseByVersion($name, $version)
    {
        return new Domain51_PEAR_Channel_Release(
            $this->_pdo,
            array(
                'package' => (string)$name,
                'version' => $version,
            )
        );
    }
}