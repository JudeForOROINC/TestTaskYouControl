<?php
if (!$argv[0]) {
    die ("This program may run CLI mode only.");

}
if (empty($argv[1])) {
    print "No arguments found! please set path to Folder to find doubles" . PHP_EOL; die;
}

$path = $argv[1];



$loader = require_once __DIR__.'/Resource/autoload.php';

// Enable APC for autoloading to improve performance.
// You should change the ApcClassLoader first argument to a unique prefix
// in order to prevent cache key conflicts with other applications
// also using APC.
/*
$apcLoader = new ApcClassLoader(sha1(__FILE__), $loader);
$loader->unregister();
$apcLoader->register(true);
*/

//$loader->

//require_once __DIR__.'/../app/AppKernel.php';
//require_once __DIR__.'/../app/AppCache.php';

//
//include_once __DIR__ . DIRECTORY_SEPARATOR . 'Resource' . DIRECTORY_SEPARATOR . 'autoload.php';

use DoublesSearchBundle\Control\SearchController;

$controll = new SearchController();

$controll->processPath($path);