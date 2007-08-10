--TEST--
The Domain51_PEAR_Channel_ReleaseList contains a collection of Releases
that are tied to a specific Package
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
$releases = new Domain51_PEAR_Channel_ReleaseList($config, $package);
assert('$releases->count() == 3');

$releases->filter('latest');
assert('$releases->count() == 2');
?>
===DONE===
--EXPECT--
===DONE===