--TEST--
The Package file has a registerExtension() method that allows you to
inject another object to handle any properties the extension declares.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(
    dirname(__FILE__) . '/..' . PATH_SEPARATOR .
    dirname(__FILE__) . '/../../src' . PATH_SEPARATOR .
    get_include_path()
);
// END REMOVE

require '_setup.inc';

class SomeGreatExtension implements Domain51_PEAR_Channel_Extension
{
    public $foo = '';
    public $bar = '';
    
    public function __construct()
    {
        $this->foo = rand(10, 20);
        $this->bar = rand(100, 200);
    }
    
    public function declaredProperties()
    {
        return array('foo', 'bar');
    }
}

$package = new Domain51_PEAR_Channel_Package(
    $config,
    'Example_Package'
);

$extension = new SomeGreatExtension();
// sanity check
assert('$extension->foo >= 10 && $extension->foo <= 20');
assert('$extension->bar >= 100 && $extension->bar <= 200');

$package->registerExtension($extension);
assert('$package->foo == $extension->foo');
assert('$package->bar == $extension->bar');

?>
===DONE===
--EXPECT--
===DONE===