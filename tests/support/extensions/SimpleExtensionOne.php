<?php

class SimpleExtensionOne implements Domain51_PEAR_Channel_Extension
{
    public $simple_message = "hello world";
    public function __construct()
    {
        
    }
    
    public function declaredProperties()
    {
        return array('simple_message');
    }
}