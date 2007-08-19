--TEST--
Dependencies are a pseudo object within a release, only existing in
the form of a serialized array within the releasees.deps field.

The current purpose of the Dependecy is to translate a "dependency"
into something human intelligent.  This may change if future versions
of Chiara_PEAR_Server move deps into another table in a more
normalized fashion so they can be searched.  As it stands, there's
no valid reason for creating pseudo objects of the column.
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

// basic just requires
$data = array(
    'type' => 'pkg',
    'channel' => 'pear.example.com',
    'name' => 'Some_Package',
    'rel' => 'has',
    'optional' => 'no',
);

$dep = new Domain51_PEAR_Channel_Dependency($config, $data);
assert('(string)$dep == "Package: Some_Package"');

// basic PEAR greater than
$data = array(
    'type' => 'pkg',
    'channel' => 'pear.php.net',
    'name' => 'PEAR',
    'rel' => 'ge',
    'version' => '1.6.0',
    'optional' => 'no',
);
$dep = new Domain51_PEAR_Channel_Dependency($config, $data);
assert('(string)$dep == "Package: PEAR 1.6.0 or newer from pear.php.net"');


// basic extension dependency
$data = array(
    'type' => 'ext',
    'name' => 'memcache',
    'rel' => 'has',
    'optional' => 'no',
);
$dep = new Domain51_PEAR_Channel_Dependency($config, $data);
assert('(string)$dep == "PHP Extension: memcache"');


    

?>
===DONE===
--EXPECT--
===DONE===