<?php

declare(strict_types=1);

namespace ExtensionDirectory;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Contracts\Cache\CacheInterface;

class Stats
{
    public function __construct(
        private CacheInterface $cacheService
    ) {}

    public function getDirSize(string $path): int
    {
        $size = 0;

        $di = new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS);
        $ri = new \RecursiveIteratorIterator($di);
        foreach ($ri as $file) {
            $size += $file->isDir() ?  $this->getDirSize($file->getRealPath()) : filesize($file->getRealPath());
        }

        return $size;
    }

    public function getStats(): array
    {
        return $this->cacheService->get('stats', function (ItemInterface $item): array {
            // Retain the stats for 24 hours
            $item->expiresAfter(86400);

            // Default stats
            $stats = [
                'extension_types' => [
                    'mod' => 0,
                    'payment-gateway' => 0,
                ],
                'author_types' => [
                    'organization' => 0,
                    'individual' => 0,
                ],
                'total_extensions' => 0,
                'total_authors' => 0,
                'cache_size' => $this->getDirSize(PATH_CACHE),
            ];

            // Now update the stats for extensions
            foreach ($this->getExtensions() as $extension) {
                $stats['extension_types'][$extension['type']]++;
                $stats['total_extensions']++;
            }

            // Last update thef stats for authors
            foreach ($this->getAuthors() as $author) {
                $stats['author_types'][$author['type']]++;
                $stats['total_authors']++;
            }

            // And return the stats
            return $stats;
        });
    }

    private function getExtensions(): array
    {
        $finder = new Finder();
        $finder->files()->in(BASE_PATH . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'Extensions')->name('*.php');
        $extensions = [];

        foreach ($finder as $file) {
            $extension = $file->getBasename('.php');
            $FQCN = '\\ExtensionDirectory\\Extensions\\' . $extension;

            if (class_exists($FQCN)) {
                $extension = new $FQCN;
                $extensions[] = [
                    'type' => $extension::TYPE,
                ];
            }
        }

        return $extensions;
    }

    private function getAuthors(): array
    {
        $finder = new Finder();
        $finder->files()->in(BASE_PATH . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'Authors')->name('*.php');
        $authors = [];

        foreach ($finder as $file) {
            $author = $file->getBasename('.php');
            $FQCN = '\\ExtensionDirectory\\Authors\\' . $author;

            if (class_exists($FQCN)) {
                $author = new $FQCN;
                $authors[] = [
                    'type' => $author::TYPE,
                ];
            }
        }

        return $authors;
    }
}
