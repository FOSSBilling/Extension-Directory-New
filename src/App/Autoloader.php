<?php

use AntCMS\AntLoader;

// Setup the auto-loader
$loader = new AntLoader([
    'path' => PATH_CACHE . DIRECTORY_SEPARATOR . 'Classmap.php',
    'mode' => 'filesystem'
]);
$loader->addNamespace('', __DIR__ . DIRECTORY_SEPARATOR . 'Components');
$loader->addNamespace('', __DIR__ . DIRECTORY_SEPARATOR . 'Library');
$loader->checkClassMap();

return $loader;
