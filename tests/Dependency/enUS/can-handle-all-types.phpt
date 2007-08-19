--TEST--
Can handle all currently known types:
* pkg = Package
* ext = PHP Extension
* php = PHP
* prog = Program
* ldlib = Development Library
* rtlib = Runtime Library
* os = Operating System
* websrv = Web Server
* sapi = SAPI Backend
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
    'name' => 'FooBar',
    'rel' => 'has',
);

$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^Package:.*/", (string)$dep)');

$data['type'] = 'ext';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^PHP Extension:.*/", (string)$dep)');

$data['type'] = 'php';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^PHP:.*/", (string)$dep)');

$data['type'] = 'prog';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^Program:.*/", (string)$dep)');

$data['type'] = 'ldlib';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^Development Library:.*/", (string)$dep)');

$data['type'] = 'rtlib';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^Runtime Library:.*/", (string)$dep)');

$data['type'] = 'os';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^Operating System:.*/", (string)$dep)');

$data['type'] = 'websrv';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^Web Server:.*/", (string)$dep)');

$data['type'] = 'sapi';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('preg_match("/^SAPI Backend:.*/", (string)$dep)');

?>
===DONE===
--EXPECT--
===DONE===