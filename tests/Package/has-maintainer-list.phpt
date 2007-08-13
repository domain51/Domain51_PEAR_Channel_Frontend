--TEST--
Domain51_PEAR_Channel_Package::$maintainers is a
Domain51_PEAR_Channel_MaintainerList containing all of the
maintainers of the given package.
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

assert('$package->maintainers instanceof Domain51_PEAR_Channel_MaintainerList');

$statement = $pdo->prepare("SELECT COUNT(*) FROM maintainers WHERE package = :package AND channel = :channel");
$statement->execute(array(
    ':package' => 'Example_Package',
    ':channel' => 'pear.example.com',
));
$total = $statement->fetchColumn();
assert('$package->maintainers->count() == $total');

?>
===DONE===
--EXPECT--
===DONE===