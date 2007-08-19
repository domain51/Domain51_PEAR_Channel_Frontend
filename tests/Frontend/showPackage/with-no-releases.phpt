--TEST--
Download and RSS Feed links are disable when no releases are made.

NOTE: This is for backward compatibility with Crtx frontend.  This might change
in future versions.
--GET--
package=Example_Package_WithNoReleases
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
assert('!preg_match("/package=Example_Package_WithNoReleases&amp;downloads\">\s*Download/", $buffer)');
assert('!preg_match("/package=Example_Package_WithNoReleases&amp;rss\">\s*RSS Feed/", $buffer)');
assert('!preg_match("/&amp;rss/", $buffer)');

?>
===DONE===
--EXPECT--
===DONE===