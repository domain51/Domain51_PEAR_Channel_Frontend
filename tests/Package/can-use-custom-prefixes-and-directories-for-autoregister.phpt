--TEST--
Domain51_PEAR_Channel_Package::autoRegister() takes two parameters:

# (string)$prefix: A custom prefix to use instead of
  Domain51_PEAR_Channel_Extension_Package_
# (string)$path: A custom path to look for files to register
  instead of &lt;include_path>/Domain51/PEAR/Channel/Extension/Package/
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

// make sure the support path is in the include_path
set_include_path(
    get_include_path() . PATH_SEPARATOR .
    dirname(__FILE__) . '/../support/extensions'
);

$package = new Domain51_PEAR_Channel_Package($config, 'Example_Package');
assert('is_null($package->simple_message)');
$package->autoRegister('', dirname(__FILE__) . '/../support/extensions');
assert('!is_null($package->simple_message)');

?>
===DONE===
--EXPECT--
===DONE===