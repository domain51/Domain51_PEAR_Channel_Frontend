--TEST--
If no matching release is found, Domain51_PEAR_Channel_Release throws a
Domain51_PEAR_Channel_Release_NotFoundException.
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

try {
    new Domain51_PEAR_Channel_Release($config, 'unknown-and-unknowable');
    trigger_error('exception not caught');
} catch (Domain51_PEAR_Channel_Release_NotFoundException $e) {
    assert('$e->getMessage() == "unable to locate release"');
    assert('$e->getCause() == array("id" => "unknown-and-unknowable")');
}

?>
===DONE===
--EXPECT--
===DONE===