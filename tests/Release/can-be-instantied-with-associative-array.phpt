--TEST--
Domain51_PEAR_Channel_Release can be given an associative of values to use
for loading.
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

$release = new Domain51_PEAR_Channel_Release(
    $config,
    array(
        'package' => 'Example_Package',
        'version' => '0.2'
    )
);

assert('(string)$release->package == "Example_Package"');
assert('(string)$release->version == "0.2"');

unset($release);

$release = new Domain51_PEAR_Channel_Release(
    $config,
    array(
        'package' => 'Example_Package',
        'version' => '0.1',
    )
);
assert('(string)$release->version == "0.1"');

?>
===DONE===
--EXPECT--
===DONE===