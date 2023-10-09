<?php
define('BASE_PATH', __DIR__);
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Bootstrap.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

$application = new Application();

$finder = new Finder();
$finder->files()->in(__DIR__ . DIRECTORY_SEPARATOR . 'App')->name('*Command.php');

foreach ($finder as $file) {
    require_once $file->getRealPath();
    $class = $file->getBasename('.php');
    $application->add(new $class());
}

$application->run();
