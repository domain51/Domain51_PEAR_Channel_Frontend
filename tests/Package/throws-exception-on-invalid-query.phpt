--TEST--
If a query fails, Domain51_PEAR_Channel_Package_UnrecoverableException
is thrown.
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

$column = "invalid_" . rand(10, 20);
try {
    new Domain51_PEAR_Channel_Package($config, array($column => 'column'));
    trigger_error('exception not caught');
} catch (Domain51_PEAR_Channel_Package_UnrecoverableException $e) {
    assert('$e->getMessage() == "problem with query"');
    $expected_cause = array("00000", 1054, "Unknown column '{$column}' in 'where clause'");
    assert('$e->getCause() == $expected_cause');
}

?>
===DONE===
--EXPECT--
===DONE===