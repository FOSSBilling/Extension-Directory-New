<?php

declare(strict_types=1);

use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
            ->public(); // Make services public so they can be accessed from the container

    // Register cache service
    if ($_ENV["CACHE_ENABLED"] === 'true') {
        $services->set('cache', FilesystemAdapter::class)
            ->args(['fs_cache', 3600, PATH_CACHE]);
    } else {
        $services->set('cache', ArrayAdapter::class);
    }

    $services->alias(CacheInterface::class, 'cache');

    // Register HTTP Client
    $services->set('http_client', HttpClientInterface::class)
        ->factory([HttpClient::class, 'create'])
        ->args([[
            'timeout' => 10,
            'max_redirects' => 5,
            'headers' => [
                'User-Agent' => 'FOSSBilling-Extension-Directory/1.0',
            ],
        ]]);

    $services->alias(HttpClientInterface::class, 'http_client');

    // Auto-register all services in ExtensionDirectory namespace
    $services->load('ExtensionDirectory\\', dirname(__DIR__) . '/Components/ExtensionDirectory/')
        ->exclude([
            dirname(__DIR__) . '/Components/ExtensionDirectory/{DependencyInjection,Entity,Migrations,Tests,Kernel.php}'
        ]);
};
