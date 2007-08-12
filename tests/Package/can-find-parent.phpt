--TEST--
The $parentPackage property contains a Package if there is a parent,
otherwise it is false.
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

$package = new Domain51_PEAR_Channel_Package($config, 'Example_Child_Package_One');
assert('$package->parentPackage instanceof Domain51_PEAR_Channel_Package');
assert('(string)$package->parentPackage == $package->parent');

$package = new Domain51_PEAR_Channel_Package($config, 'Example_Parent_Package');
assert('$package->parentPackage === false');

?>
===DONE===
--EXPECT--
===DONE===