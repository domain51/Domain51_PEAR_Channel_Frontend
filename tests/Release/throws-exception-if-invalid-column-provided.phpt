--TEST--
Will throw a Domain51_PEAR_Channel_Release_UnrecoverableException when an
unknown column (i.e., invalid SQL) is detected.
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
    $column = 'unknown_' . rand(1, 20);
    new Domain51_PEAR_Channel_Release(
        $pdo,
        array($column => 123)
    );
    trigger_error('exception not caught');
} catch (Domain51_PEAR_Channel_Release_UnrecoverableException $e) {
    assert('$e->getMessage() == "problem with query"');
    $expected_cause = array("00000", 1054, "Unknown column '{$column}' in 'where clause'");
    assert('$e->getCause() == $expected_cause');
}

?>
===DONE===
--EXPECT--
===DONE===