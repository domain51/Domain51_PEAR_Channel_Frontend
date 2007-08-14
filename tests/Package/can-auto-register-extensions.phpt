--TEST--
if autoRegister() is called, Domain51_PEAR_Channel_Package will scan
Domain51/PEAR/Channel/Extension/Package/ for extensions and
automatically register all of them.
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
assert('is_null($package->cvs_uri)');
$package->autoRegister();
assert('!is_null($package->cvs_uri)');

?>
===DONE===
--EXPECT--
===DONE===