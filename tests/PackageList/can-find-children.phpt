--TEST--
Can find children when passed a parent value
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

$packageList = new Domain51_PEAR_Channel_PackageList(
    $config,
    array('parent' => 'Example_Parent_Package')
);

$statement = $pdo->prepare("SELECT COUNT(*) FROM packages WHERE parent = 'Example_Parent_Package'");
$statement->execute();
$total = $statement->fetchColumn();
assert('$packageList->count() == $total');

?>
===DONE===
--EXPECT--
===DONE===