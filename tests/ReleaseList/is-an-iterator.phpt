--TEST--
Domain51_PEAR_Channel_ReleaseList is an Iterator
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

$package = new Domain51_PEAR_Channel_Package($config, 'Example_Package');
$releases = new Domain51_PEAR_Channel_ReleaseList($config, $package);

assert('$releases instanceof Iterator');

assert('$releases->valid()');
assert('$releases->current() instanceof Domain51_PEAR_Channel_Release');

for ($releases->rewind(); $releases->valid(); $releases->next()) {
    
}

assert('!$releases->valid()');
$releases->rewind();
assert('$releases->valid()');

// test foreach
$old_key = null;
foreach ($releases as $key => $release)
{
    assert('$old_key !== $key');
    $old_key = $key;
    assert('$release instanceof Domain51_PEAR_Channel_Release');
    assert('(string)$release->package == "Example_Package"');
    assert('(string)$release->channel == "pear.example.com"');
}

?>
===DONE===
--EXPECT--
===DONE===