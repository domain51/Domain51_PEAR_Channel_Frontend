--TEST--
Dependency is able to handle all "rel" types.  Assuming version 1.3.2:
* lt = older than 1.3.2
* le = 1.3.2 or older
* eq = version 1.3.2
* ne = any version but 1.3.2
* gt = newer than 1.3.2
* ge = 1.3.2 or newer
* has = &lt;empty>
--FILE--
<?php
// BEGIN REMOVE
set_include_path(
    dirname(__FILE__) . '/../..' . PATH_SEPARATOR .
    dirname(__FILE__) . '/../../../src' . PATH_SEPARATOR .
    get_include_path()
);
// END REMOVE

require '_setup.inc';

$data = array(
    'type' => 'pkg',
    'channel' => 'pear.example.com',
    'name' => 'Some_Package',
    'version' => '1.3.2',
    'rel' => 'has',
    'optional' => 'no',
);
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "Package: Some_Package"');

$data['rel'] = 'lt';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "Package: Some_Package older than 1.3.2"');

$data['rel'] = 'le';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "Package: Some_Package 1.3.2 or older"');

$data['rel'] = 'eq';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "Package: Some_Package version 1.3.2"');

$data['rel'] = 'ne';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "Package: Some_Package any version but 1.3.2"');

$data['rel'] = 'gt';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "Package: Some_Package newer than 1.3.2"');

$data['rel'] = 'ge';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "Package: Some_Package 1.3.2 or newer"');

?>
===DONE===
--EXPECT--
===DONE===