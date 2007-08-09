--TEST--
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

$release = new Domain51_PEAR_Channel_Release($pdo, '1');
assert('(string)$release->package == "Example_Package"');
assert('(string)$release->channel == "pear.example.com"');

?>
===DONE===
--EXPECT--
===DONE===