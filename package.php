<?php
require_once('PEAR/PackageFileManager2.php');
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$packagexml = new PEAR_PackageFileManager2;

$version_release = '1.0';
$version_api = $version_release;
$state = 'beta';

$notes = '';

$summary = 'Excel generator';

$description = '';

$packagefile = './package.xml';

$options = array(
    'filelistgenerator' => 'svn',
    'changelogoldtonew' => false,
    'simpleoutput'      => true,
    'baseinstalldir'    => '/',
    'packagedirectory'  => './',
    'packagefile'       => $packagefile,
    'clearcontents'     => false,
    'ignore'            => array(
        'package*.php',
        'package*.xml',
    ),
    'dir_roles'         => array(
        'config'           => 'php',
        'examples'        => 'php',
        'lib'         => 'php',
    ),
    'exceptions' => array(
        'README' => 'doc',
        'LICENSE' => 'doc'
    )
);

$package = &PEAR_PackageFileManager2::importOptions($packagefile, $options);
$package->setPackageType('php');

$package->clearDeps();
$package->setPhpDep('5.2.0');
$package->setPearInstallerDep('1.4.0b1');
$package->addPackageDepWithChannel('required', 'PEAR', 'pear.php.net', '1.3.6');

$package->addRelease();
$package->generateContents();
$package->setReleaseVersion($version_release);
$package->setAPIVersion($version_api);
$package->setReleaseStability($state);
$package->setAPIStability($state);
$package->setNotes($notes);
$package->setSummary($summary);
$package->setDescription($description);
$package->addGlobalReplacement('package-info', '@package_version@', 'version');


if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $package->writePackageFile();
} else {
    $package->debugPackageFile();
}
