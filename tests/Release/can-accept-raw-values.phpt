--TEST--
If the $criteria supplied has a "_RAW_VALUES" key that is true,
Domain51_PEAR_Channel_Release assumes it has been handed in a
raw data set and does not query the database.
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

$array = array(
    'package' => 'Vendor_Example',
    'channel' => 'pear.example.org',
    '_RAW_VALUES' => true
);

$release = new Domain51_PEAR_Channel_Release($config, $array);
assert('(string)$release->package == "Vendor_Example"');
assert('(string)$release->channel == "pear.example.org"');

?>
===DONE===
--EXPECT--
===DONE===