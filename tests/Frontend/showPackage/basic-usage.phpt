--TEST--
With default settings, this displays package's web page.
--GET--
package=Example_Package
--FILE--
<?php
// BEGIN REMOVE
set_include_path(
    dirname(__FILE__) . '/../..' . PATH_SEPARATOR .
    dirname(__FILE__) . '/../../../src' . PATH_SEPARATOR .
    get_include_path()
);
// END REMOVE

require '_setup.inc';

$frontend_config = array(
    'database' => 'mysql://root:@localhost/test_pear_channel',
);

$frontend = new Domain51_PEAR_Channel_Frontend('pear.example.com', $frontend_config);
ob_start();
$frontend->showPackage();
$buffer = ob_get_clean();

// check for errors
assert('!preg_match("/.*PHP (Notice|Error|Warning).*/", $buffer)');

assert('strlen($buffer) > 0');
assert('preg_match("/Example_Package/", $buffer)');
assert('preg_match("/package=Example_Package&amp;downloads\">\s*Download/", $buffer)');

?>
===DONE===
--EXPECT--
===DONE===