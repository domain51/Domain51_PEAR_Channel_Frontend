--TEST--
$handle property is a Domain51_PEAR_Channel_Handle object
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
$maintainer = new Domain51_PEAR_Channel_Maintainer(
    $config,
    array(
        'handle' => 'lead-dev',
        'package' => 'Example_Package',
    )
);

assert('$maintainer->handle instanceof Domain51_PEAR_Channel_Handle');
assert('$maintainer->handle->handle == "lead-dev"');
?>
===DONE===
--EXPECT--
===DONE===