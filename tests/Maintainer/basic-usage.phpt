--TEST--
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

assert('(string)$maintainer->channel == "pear.example.com"');
assert('(string)$maintainer->handle == "lead-dev"');
assert('(string)$maintainer->package == "Example_Package"');
assert('$maintainer->package instanceof Domain51_PEAR_Channel_Package');

?>
===DONE===
--EXPECT--
===DONE===