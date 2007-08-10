--TEST--
If you echo a Package object, you'll get the name
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

$package = new Domain51_PEAR_Channel_Package($config, 'Example_Package');
assert('(string)$package == "Example_Package"');

$alt_config = new Domain51_PEAR_Channel_Config(array(
    'pdo' => $pdo,
    'channel' => 'pear.example.net',
));
$package = new Domain51_PEAR_Channel_Package($alt_config, 'Example_Package_Alternative');
assert('(string)$package == "Example_Package_Alternative"');

?>
===DONE===
--EXPECT--
===DONE===