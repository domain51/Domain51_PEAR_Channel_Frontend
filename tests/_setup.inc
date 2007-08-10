<?php

require 'Domain51/Loader.php';

$database_name = 'test_pear_channel';
$pdo = new PDO('mysql://root:@', 'root', '');
$config = new Domain51_PEAR_Channel_Config(array(
    'pdo' => $pdo,
    'channel' => 'pear.example.com',
));

$pdo->exec("DROP DATABASE IF EXISTS $database_name");
$pdo->exec("CREATE DATABASE {$database_name}");
$pdo->exec("USE {$database_name}");

$pdo->exec("
CREATE TABLE `releases` (
    `id` int(11) NOT NULL default '0',
    `channel` varchar(255) NOT NULL default '',
    `package` varchar(80) NOT NULL default '',
    `version` varchar(20) NOT NULL default '',
    `state` enum('stable','beta','alpha','devel','snapshot') NOT NULL default 'stable',
    `maintainer` varchar(20) NOT NULL default '',
    `license` varchar(20) NOT NULL default '',
    `summary` text NOT NULL,
    `description` text NOT NULL,
    `releasedate` datetime NOT NULL default '0000-00-00 00:00:00',
    `releasenotes` text NOT NULL,
    `filepath` text NOT NULL,
    `packagexml` longtext NOT NULL,
    `deps` text NOT NULL,
    PRIMARY KEY  (`id`),
    UNIQUE KEY `version` (`channel`(100),`package`,`version`),
    KEY `channel` (`channel`(100),`package`)
)
");

$pdo->exec("
    INSERT INTO `releases`
        (
            id,
            channel,
            package,
            version,
            state,
            maintainer,
            license,
            summary,
            description,
            releasedate,
            releasenotes,
            filepath,
            packagexml,
            deps
        )
    VALUES
        (
            1,
            'pear.example.com',
            'Example_Package',
            '0.1',
            'alpha',
            'lead-dev',
            'LGPL',
            'A useful summary',
            'A more full description',
            NOW() - (60 * 60 * 24 * 7 * 4),
            'Initial release',
            '/path/to/release/Example_Package-0.1alpha.tgz',
            '',
            ''
        ),
        (
            2,
            'pear.example.com',
            'Example_Package',
            '0.2',
            'beta',
            'lead-dev',
            'LGPL',
            'A useful summary',
            'A more full description',
            NOW() - (60 * 60 * 24 * 7 * 4),
            'Initial release',
            '/path/to/release/Example_Package-0.2beta.tgz',
            '',
            ''
        ),
        (
            3,
            'pear.example.com',
            'Example_Package',
            '0.2.1',
            'alpha',
            'lead-dev',
            'LGPL',
            'A useful summary',
            'A more full description',
            NOW() - (60 * 60 * 24 * 7 * 4),
            'Third release, second alpha',
            '/path/to/release/Example_Package-0.2.1beta.tgz',
            '',
            ''
        )
");


$pdo->exec("
    CREATE TABLE `packages` (
        `channel` varchar(255) NOT NULL default '',
        `category_id` int(6) NOT NULL default '0',
        `package` varchar(80) NOT NULL default '',
        `license` varchar(20) NOT NULL default '',
        `licenseuri` varchar(150) NOT NULL default '',
        `summary` text NOT NULL,
        `description` text NOT NULL,
        `parent` varchar(80) default NULL,
        `deprecated_package` varchar(80) NOT NULL default '',
        `deprecated_channel` varchar(255) NOT NULL default '',
        PRIMARY KEY  (`channel`(100),`package`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1
");

$pdo->exec("
    INSERT INTO packages
        (channel, package, license, licenseuri, summary, description, parent)
    VALUES
        (
            'pear.example.com',
            'Example_Package',
            'LGPL',
            'http://uri',
            'A useful summary',
            'A more full description',
            0
        ),
        (
            'pear.example.net',
            'Example_Package_Alternative',
            'LGPL',
            'http://uri',
            'Should be a summary',
            'Should be a full description',
            0
        ),
        (
            'pear.example.net',
            'Example_Package',
            'Non-LGPL',
            'http://uri',
            'A useful summary of a conflicting package name on a different channel',
            'A more full description of said package',
            0
        )
");