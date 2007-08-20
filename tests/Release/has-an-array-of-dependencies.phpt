--TEST--
The $dependencies property is an array representing the dependencies
of a given package.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(
    dirname(__FILE__) . '/..' . PATH_SEPARATOR .
    get_include_path()
);
// END REMOVE

require '_setup.inc';

$release = new Domain51_PEAR_Channel_Release($config, '4');
assert('is_array($release->dependencies)');

$known_deps = array(
    new Domain51_PEAR_Channel_Dependency_enUS(
        $config,
        array(
            'type' => 'php',
            'rel' => 'ge',
            'version' => '5.2.3',
            'optional' => 'no',
        )
    ),
    new Domain51_PEAR_Channel_Dependency_enUS(
        $config,
        array(
            'type' => 'pkg',
            'channel' => 'pear.php.net',
            'name' => 'PEAR',
            'rel' => 'ge',
            'version' => '1.6.0',
            'optional' => 'no',
        )
    ),
    new Domain51_PEAR_Channel_Dependency_enUS(
        $config,
        array(
            'type' => 'pkg',
            'channel' => 'pear.example.com',
            'name' => 'Example_Package',
            'rel' => 'has',
            'optional' => 'no',
        )
    ),
);

assert('count($known_deps) == count($release->dependencies)');

foreach ($release->dependencies as $key => $dependency) {
    assert('(string)$dependency == (string)$known_deps[$key]');
}

?>
===DONE===
--EXPECT--
===DONE===