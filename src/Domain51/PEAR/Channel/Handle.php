<?php

class Domain51_PEAR_Channel_Handle extends Domain51_PEAR_Channel_AbstractDBModel
{
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria)
    {
        if (!is_array($criteria)) {
            $criteria = array(
                'handle' => $criteria,
            );
        }
        parent::__construct($config, $criteria);
    }
    
    public function __get($key)
    {
        return parent::__get($key);
    }
    
    public function __toString()
    {
        return $this->handle;
    }
}