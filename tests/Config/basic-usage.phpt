--TEST--
Domain51_PEAR_Channel_Config takes an array and makes it available
via properties of its config.
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
    'random' => rand(1, 20),
    'string' => 'Hello World',
);

$config = new Domain51_PEAR_Channel_Config($array);
foreach ($array as $key => $value) {
    assert('$config->$key == $value');
}

?>
===DONE===
--EXPECT--
===DONE===