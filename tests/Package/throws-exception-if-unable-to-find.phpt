--TEST--
Will throw a Domain51_PEAR_Channel_Package_NotFoundException if
unable to find a matching package
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
    new Domain51_PEAR_Channel_Package($config, 'UnknownPackage');
    trigger_error('exception not caught');
} catch (Domain51_PEAR_Channel_Package_NotFoundException $e) {
    assert('$e->getMessage() == "unable to locate package"');
    $expected = array(
        'package' => 'UnknownPackage',
        'channel' => 'pear.example.com',
    );
    assert('$e->getCause() == $expected');
}

?>
===DONE===
--EXPECT--
===DONE===