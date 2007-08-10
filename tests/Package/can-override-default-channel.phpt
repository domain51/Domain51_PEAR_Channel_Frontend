--TEST--
If a "channel" value is provided in the $criteria array, it will
override the channel property of the passed in config object.
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

$package = new Domain51_PEAR_Channel_Package(
    $config,
    array(
        'package' => 'Example_Package_Alternative',
        'channel' => 'pear.example.net',
    )
);

assert('$package->package == "Example_Package_Alternative"');
assert('$package->channel == "pear.example.net"');
?>
===DONE===
--EXPECT--
===DONE===