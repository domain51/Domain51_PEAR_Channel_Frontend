--TEST--
Domain51_PEAR_Channel_Factory can load a Release object by version
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

$factory = new Domain51_PEAR_Channel_Factory($pdo);
$release = $factory->loadReleaseByVersion('Example_Package', '0.1');

assert('$release instanceof Domain51_PEAR_Channel_Release');
assert('(string)$release->package == "Example_Package"');
assert('(string)$release->version == "0.1"');

unset($release);

$release = $factory->loadReleaseByVersion('Example_Package', '0.2');
assert('(string)$release->version == "0.2"');

?>
===DONE===
--EXPECT--
===DONE===