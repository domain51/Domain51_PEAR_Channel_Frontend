--TEST--
Domain51_PEAR_Channel_Package is a Model object representing a package
within the channel.
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

// psuedo code
//$config = new Domain51_PEAR_Channel_Config(array(
//    'pdo' => $pdo,
//    'channel' => 'pear.example.com',
//));

$package = new Domain51_PEAR_Channel_Package($pdo, 'Example_Package');
assert('$package->package == "Example_Package"');
assert('$package->license == "LGPL"');

assert('$package->releases instanceof Domain51_PEAR_Channel_ReleaseList');
assert('$package->releases->count() == 2');

?>
===DONE===
--EXPECT--
===DONE===