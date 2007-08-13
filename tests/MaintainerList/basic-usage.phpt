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

$maintainerList = new Domain51_PEAR_Channel_MaintainerList($config);

$statement = $pdo->prepare('SELECT COUNT(*) FROM maintainers');
$statement->execute();
$total = $statement->fetchColumn();

assert('$total > 0');
assert('$total == $maintainerList->count()');

$i = 0;
for ($maintainerList->rewind(); $maintainerList->valid(); $maintainerList->next()) {
    $i++;
}
assert('$i == $total');


$maintainerList->rewind();
for ($i = 0; $i < $total; $i++) {
    assert('$maintainerList->valid()');
    assert('$maintainerList->key() == $i');
    $maintainerList->next();
}

assert('!$maintainerList->valid()');
$maintainerList->rewind();
assert('$maintainerList->valid()');

$maintainerList->rewind();
assert('$maintainerList->current() instanceof Domain51_PEAR_Channel_Maintainer');
?>
===DONE===
--EXPECT--
===DONE===