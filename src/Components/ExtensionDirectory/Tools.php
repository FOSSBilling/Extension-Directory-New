<?php

declare(strict_types=1);

namespace ExtensionDirectory;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

class Tools
{
    public function __construct(
        private readonly CacheInterface $cache
    ) {
    }

    /**
     * Returns the completed license info depending on what items are missing.
     * As long as the SPDX ID is passed, this function will fetch the name of the license as well as a link to it.
     */
    public function completeLicenseInfo(array $license): array
    {
        $key = 'license_' . hash('xxh3', serialize($license));

        return $this->cache->get($key, function (ItemInterface $item) use ($license): array {
            $item->expiresAfter(86400 * 7); // Cache this result for a full week as it should very rarely change.

            if (!empty($license['id']) && (empty($license['url']) || empty($license['name']))) {
                try {
                    $licenses = new \Composer\Spdx\SpdxLicenses();
                    $fetchedLicense = $licenses->getLicenseByIdentifier($license['id']);
                } catch (\Exception) {
                    $fetchedLicense = [];
                }

                if (isset($fetchedLicense[2]) && str_contains($fetchedLicense[2], 'https://')) {
                    $license['url'] ??= $fetchedLicense[2];
                }

                if (isset($fetchedLicense[0])) {
                    $license['name'] ??= $fetchedLicense[0];
                }
            }

            return $license;
        });
    }

    public function returnAuthorInfo(string $author): array
    {
        $FQCN = '\\ExtensionDirectory\\Authors\\' . $author;
        if (!class_exists($FQCN)) {
            return [];
        }

        $authorClass = new $FQCN();
        return [
            'type' => $authorClass::TYPE,
            'name' => $authorClass::NAME,
            'id'   => $authorClass::ID,
            'url'  => $authorClass::URL,
        ];
    }

    public function getRepoType(string $url): string
    {
        $repoHosts = [
            'github.com' => 'github',
            'bitbucket.org' => 'bitbucket',
            'gitlab.com' => 'gitlab',
            'sourceforge.net' => 'sourceforge',
        ];

        foreach ($repoHosts as $host => $type) {
            if (str_contains($url, $host)) {
                return $type;
            }
        }

        return 'unknown';
    }

    public function getRepoName(string $url): string
    {
        $repoHosts = [
            'github.com' => 'https://github.com/',
            'bitbucket.org' => 'https://bitbucket.org/',
            'gitlab.com' => 'https://gitlab.com/',
            'sourceforge.net' => 'https://sourceforge.net/projects/',
        ];

        foreach ($repoHosts as $host => $prefix) {
            if (str_contains($url, $host)) {
                $repoName = str_replace($prefix, '', $url);
                return rtrim($repoName, '/');
            }
        }

        return $url;
    }
}
