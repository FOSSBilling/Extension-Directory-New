<?php

namespace ExtensionDirectory;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class Tools
{
    /** 
     * @return array<string> 
     */
    public static function getFileList(string $dir, ?string $extension = null, ?bool $returnPath = false)
    {
        $dir = new \RecursiveDirectoryIterator($dir);
        $iterator = new \RecursiveIteratorIterator($dir);
        $files = array();
        foreach ($iterator as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == $extension || $extension == null) {
                $files[] = ($returnPath) ? $file->getPathname() : $file->getFilename();
            }
        }

        return $files;
    }

    /**
     * Returns the completed license info depending on what items are missing.
     * As long as the SPDX ID is passed, this function will fetch the name of the license as well as a link to it.
     */
    public static function completeLicenseInfo(array $license): array
    {
        $cache = new FilesystemAdapter('licenseInfo', 3600, PATH_CACHE);
        $key = serialize($license);

        return $cache->get($key, function (ItemInterface $item) use ($license): array {
            $item->expiresAfter(86400 * 7); // Cache this result for a full week as it should very rarely change.

            if (!empty($license['id']) && (empty($license['link']) || empty($license['name']))) {
                try {
                    $licenses = new \Composer\Spdx\SpdxLicenses();
                    $fetchedLicense = $licenses->getLicenseByIdentifier($license['id']);
                } catch (\Exception) {
                    $fetchedLicense = [];
                }

                if (isset($fetchedLicense[2]) && str_contains($fetchedLicense[2], 'https://')) {
                    $license['link'] ??= $fetchedLicense[2];
                }

                if (isset($fetchedLicense[0])) {
                    $license['name'] ??= $fetchedLicense[0];
                }
            }

            return $license;
        });
    }

    public static function getRepoInfo(array $source): array
    {
        if (empty($source['link'])) {
            switch ($source['type']) {
                case 'github':
                    $source['link'] = 'https://github.com/' . $source['repo'];
                case 'bitbucket':
                    $source['link'] = 'https://bitbucket.org/' . $source['repo'];
                case 'gitlab':
                    $source['link'] = 'https://gitlab.com/' . $source['repo'];
                default:
                    $source['link'] = '';
            }
        }
        return $source;
    }

    public static function returnAuthorInfo(string $author): array
    {
        $FQCN = '\\ExtensionDirectory\\Authors\\' . $author;
        if (!class_exists($FQCN)) {
            return [];
        }

        $authorClass = new $FQCN;
        return [
            'type' => $authorClass::type,
            'name' => $authorClass::name,
            'id' => $authorClass::id,
            'link' => $authorClass::link,
        ];
    }
}
