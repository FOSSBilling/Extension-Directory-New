<?php

use AntCMS\AntLoader;

// Setup the auto-loader
$loader = new AntLoader([
    'path' => PATH_CACHE . DIRECTORY_SEPARATOR . 'Classmap.php',
    'mode' => $_ENV["CACHE_ENABLED"] === 'true' ? 'filesystem' : 'none',
]);
$loader->addNamespace('', BASE_PATH . DIRECTORY_SEPARATOR . 'Components');
$loader->addNamespace('ExtensionDirectory\\', BASE_PATH . DIRECTORY_SEPARATOR . 'Library');
$loader->checkClassMap();

return $loader;
