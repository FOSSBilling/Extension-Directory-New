<?php

namespace ExtensionDirectory;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class LicenseHelper
{
    public static function completeLicenseInfo(array $license): array
    {
        $cache = new FilesystemAdapter('licenseInfo', 3600, PATH_CACHE);
        $id = $license['id'] ?? '';

        return $cache->get($id, function (ItemInterface $item) use ($license): array {
            $item->expiresAfter(86400 * 7); // Cache this result for a full week as it should very rarely change.

            if ($license['id'] && (!$license['link'] || !$license['name'])) {
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
}
