--TEST--
When the "downloads" variable is present in a GET request, show only
the list of releases for a given package.
--GET--
package=Example_Package&downloads
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

assert('!preg_match("/.*PHP (Notice|Error|Warning).*/", $buffer)');
assert('preg_match("/<h3>Downloads<\/h3>/", $buffer)');

?>
===DONE===
--EXPECT--
===DONE===