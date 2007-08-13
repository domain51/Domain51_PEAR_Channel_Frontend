--TEST--
Can be registered with a package as an extension
--FILE--
<?php
// BEGIN REMOVE
set_include_path(
    dirname(__FILE__) . '/../../..' . PATH_SEPARATOR .
    dirname(__FILE__) . '/../../../../src' . PATH_SEPARATOR .
    get_include_path()
);
// END REMOVE

require '_setup.inc';


$package = new Domain51_PEAR_Channel_Package($config, 'Example_Package');
$extras = new Domain51_PEAR_Channel_Extension_Package_CrtxExtra($config, $package);
// sanity check
assert('is_null($package->docs_uri)');
assert('is_null($package->bugs_uri)');

$package->registerExtension($extras);
assert('$package->docs_uri == "docs://uri"');
assert('$package->bugs_uri == "bugs://uri"');

?>
===DONE===
--EXPECT--
===DONE===