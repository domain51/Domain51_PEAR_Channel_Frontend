--TEST--
If the config object is instantiated without a 'locale' value, it defaults to 'enUS'
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

$config = new Domain51_PEAR_Channel_Config(array());
assert('$config->locale == "enUS"');

$config = new Domain51_PEAR_Channel_Config(array('locale' => 'enGB'));
assert('$config->locale == "enGB"');

?>
===DONE===
--EXPECT--
===DONE===