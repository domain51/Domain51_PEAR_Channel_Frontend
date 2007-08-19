--TEST--
Can display a PHP version dependency
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
// PHP version requirement
$data = array(
    'type' => 'php',
    'rel' => 'ge',
    'version' => '5.2.3',
    'optional' => 'no',
);
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "PHP: 5.2.3 or newer"');

$data['rel'] = 'le';
$dep = new Domain51_PEAR_Channel_Dependency_enUS($config, $data);
assert('(string)$dep == "PHP: 5.2.3 or older"');

?>
===DONE===
--EXPECT--
===DONE===