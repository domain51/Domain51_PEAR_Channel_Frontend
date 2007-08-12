--TEST--
Each package as a (bool)$has_children property that specifies if
a package has any children packages.  The $childPackages properties
is a Domain51_PEAR_Channel_PackageList containing any children
packages.
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
assert('!$package->has_children');
assert('$package->childPackages instanceof Domain51_PEAR_Channel_PackageList');
assert('!$package->childPackages->valid()');

$package = new Domain51_PEAR_Channel_Package($config, 'Example_Parent_Package');
assert('$package->has_children');
assert('$package->childPackages->valid()');

?>
===DONE===
--EXPECT--
===DONE===