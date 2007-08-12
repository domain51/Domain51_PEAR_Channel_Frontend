<?php

class Domain51_PEAR_Channel_Release extends Domain51_PEAR_Channel_AbstractDBModel
{
    public function __construct(Domain51_PEAR_Channel_Config $config, $criteria)
    {
        if (!is_array($criteria)) {
            $criteria = array('id' => $criteria);
        }
        parent::__construct($config, $criteria);
    }
}

class Domain51_PEAR_Channel_Release_NotFoundException extends PEAR_Exception { }
class Domain51_PEAR_Channel_Release_UnrecoverableException extends PEAR_Exception { }