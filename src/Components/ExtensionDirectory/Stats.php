<?php

namespace ExtensionDirectory;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Finder\Finder;

class Stats
{
    public static function calculatePagination(object $cacheService, int $itemsPerPage = 100): int
    {
        $itemsPerPage = ($itemsPerPage > 100) ? 100 : $itemsPerPage;
        $stats = self::getStats($cacheService);

        return ceil($stats['total_extensions'] / $itemsPerPage);
    }

    public static function getStats(object $cacheService)
    {
        return $cacheService->get('stats', function (ItemInterface $item): array {
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
            ];

            // Now update the stats for extensions
            foreach (self::getExtensions() as $extension) {
                $stats['extension_types'][$extension['type']]++;
                $stats['total_extensions']++;
            }

            // Last update thef stats for authors
            foreach (self::getAuthors() as $author) {
                $stats['author_types'][$author['type']]++;
                $stats['total_authors']++;
            }

            // And return the stats
            return $stats;
        });
    }

    private static function getExtensions(): array
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
                    'type' => $extension::type,
                ];
            }
        }

        return $extensions;
    }

    private static function getAuthors(): array
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
                    'type' => $author::type,
                ];
            }
        }

        return $authors;
    }
}
