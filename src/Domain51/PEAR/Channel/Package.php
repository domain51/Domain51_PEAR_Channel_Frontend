<?php

class Domain51_PEAR_Channel_Package
{
    private $_data = null;
    
    public function __construct($package, $channel)
    {
        $package = DB_DataObject::factory('packages');
        $package->package = $package;
        $package->channel = $channel;
        if ($package->find(true)) {
            $this->_data = false;
        } else {
            $this->_data = $package->toArray();
        }
    }
    
    public function isValid()
    {
        return $this->_data !== false;
    }
    
    public function __get($key)
    {
        // if we already know this value, return it
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        }
        
        switch ($key) {    
            case 'category' :
                return $this->_initCategory();
            
            case 'releases' :
                return $this->_initReleases();
        }
    }
    
    private function _initCategory()
    {
        $category = DB_DataObject::factory('categories');
        $category->channel = $this->channel;
        $category->id = $this->category_id;
        $this->_data['category'] = $category->find(true) ? $category->name : 'Default';
        return $this->_data['category'];
    }
    
    private function _initReleases()
    {
        $this->_data['releases'] = new Domain51_PEAR_Channel_ReleaseList($this);
        return $this->_data['releases'];
    }
}