--TEST--
Is a package extension to handle the package_extras table that Davey
Shafik introduces in his Crtx_PEAR_Channel_Frontend package.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(
    dirname(__FILE__) . '/../../..' . PATH_SEPARATOR .
    dirname(__FILE__) . '/../../../../src' . PATH_SEPARATOR .
    get_include_path()
);
// END REMOVE

require '_setup.inc';

$package = new Domain51_PEAR_Channel_Package($config, 'Example_Package');
$extras = new Domain51_PEAR_Channel_Extension_Package_CrtxExtra($config, $package);

$expected = array(
    'cvs_uri',
    'bugs_uri',
    'docs_uri',
    'qa_approval',
    'unit_tested',
);
assert('$extras->declaredProperties() == $expected');
assert('$extras->package == $package');
assert('$extras->cvs_uri == "cvs://uri"');
assert('$extras->bugs_uri == "bugs://uri"');
assert('$extras->docs_uri == "docs://uri"');
assert('$extras->qa_approval === true');
assert('$extras->unit_tested === true');

$package = new Domain51_PEAR_Channel_Package(
    $config,
    array(
        'package' => 'Example_Package',
        'channel' => 'pear.example.net',
    )
);
$extras = new Domain51_PEAR_Channel_Extension_Package_CrtxExtra($config, $package);
assert('$extras->qa_approval === false');
assert('$extras->unit_tested === false');
    

?>
===DONE===
--EXPECT--
===DONE===