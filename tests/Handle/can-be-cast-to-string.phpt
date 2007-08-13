--TEST--
If a Handle object is cast to a string, the handle property will be
echoed out.
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

$handle = new Domain51_PEAR_Channel_Handle($config, 'lead-dev');
assert('$handle->handle == (string)$handle');

?>
===DONE===
--EXPECT--
===DONE===