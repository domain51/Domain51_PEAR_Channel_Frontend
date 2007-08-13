--TEST--
Domain51_PEAR_Channel_Handle represents handle data
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

assert('(string)$handle->channel == "pear.example.com"');
assert('(string)$handle->handle == "lead-dev"');
assert('(string)$handle->name == "Lead Developer"');
assert('(string)$handle->email == "email@example.com"');

?>
===DONE===
--EXPECT--
===DONE===