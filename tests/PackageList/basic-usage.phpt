--TEST--
Is passed a config object and an optional set of criteria and creates
an Iterator of all matching packages
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

$packageList = new Domain51_PEAR_Channel_PackageList($config);
assert('$packageList instanceof Iterator');

$statement = $pdo->prepare('SELECT COUNT(*) FROM packages');
$statement->execute();
$total = $statement->fetchColumn();
assert('$packageList->count() == $total');

$i = 0;
for ($packageList->rewind(); $packageList->valid(); $packageList->next()) {
    $i++;
}

assert('$i > 0');
assert('$total == $i');

$packageList->rewind();
for ($i = 0; $i < $total; $i++) {
    assert('$packageList->key() == $i');
    assert('$packageList->valid()');
    $packageList->next();
}
$packageList->next();
assert('!$packageList->valid()');

$packageList->rewind();
assert('$packageList->current() instanceof Domain51_PEAR_Channel_Package');


?>
===DONE===
--EXPECT--
===DONE===