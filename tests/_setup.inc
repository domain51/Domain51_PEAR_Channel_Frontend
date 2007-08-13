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

// add in package with parents and children
$pdo->exec("
    INSERT INTO packages
        (channel, package, parent)
    VALUES
        ('pear.example.com', 'Example_Parent_Package', 0),
        ('pear.example.com', 'Example_Child_Package_One', 'Example_Parent_Package'),
        ('pear.example.com', 'Example_Child_Package_Two', 'Example_Parent_Package')
");


// add in maintainers
$pdo->exec("
    CREATE TABLE `maintainers` (
        `handle` varchar(20) NOT NULL default '',
        `channel` varchar(255) NOT NULL default '',
        `package` varchar(80) NOT NULL default '',
        `role` varchar(30) NOT NULL default 'lead',
        `active` tinyint(4) NOT NULL default '1',
        PRIMARY KEY  (`handle`,`channel`(100),`package`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1
");

$pdo->exec("
    INSERT INTO maintainers
        (handle, channel, package, role, active)
    VALUES
        ('lead-dev', 'pear.example.com', 'Example_Package', 'lead', 1),
        ('inactive-lead-dev', 'pear.example.com', 'Example_Package', 'lead', 0)
");

$pdo->exec("
    CREATE TABLE `handles` (
        `channel` varchar(255) NOT NULL default '',
        `handle` varchar(20) NOT NULL default '',
        `name` varchar(255) NOT NULL default '',
        `email` varchar(255) NOT NULL default '',
        `uri` varchar(255) default NULL,
        `description` text,
        `wishlist` text,
        `password` varchar(50) NOT NULL default '',
        `admin` int(11) NOT NULL default '0',
        PRIMARY KEY  (`channel`(100),`handle`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1
");

$pdo->exec("
    INSERT INTO handles
        (channel, handle, name, email, admin)
    VALUE
        ('pear.example.com', 'lead-dev', 'Lead Developer', 'email@example.com', 1),
        ('pear.example.com', 'inactive-lead-dev', 'Inactive Lead Developer', 'alt_email@example.com', 0)
");


// Add in package_extras table and some sample data
$pdo->exec("
    CREATE TABLE `package_extras` (
        `channel` varchar(255) NOT NULL default '',
        `package` varchar(80) NOT NULL default '',
        `cvs_uri` varchar(255) NOT NULL default '',
        `bugs_uri` varchar(255) NOT NULL default '',
        `docs_uri` varchar(255) NOT NULL default '',
        `qa_approval` int(1) NOT NULL default '0',
        `unit_tested` int(1) NOT NULL default '0',
        PRIMARY KEY  (`channel`(100),`package`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1
");
$pdo->exec("
    INSERT INTO package_extras
        (channel, package, cvs_uri, bugs_uri, docs_uri, qa_approval, unit_tested)
    VALUES
        ('pear.example.com', 'Example_Package', 'cvs://uri', 'bugs://uri', 'docs://uri', 1, 1),
        ('pear.example.net', 'Example_Package', 'cvs://uri', 'bugs://uri', 'docs://uri', 0, 0)
");