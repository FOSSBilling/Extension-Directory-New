<?php

namespace ExtensionDirectory;

use Symfony\Contracts\Cache\ItemInterface;

class Tools
{
    /**
     * Returns the completed license info depending on what items are missing.
     * As long as the SPDX ID is passed, this function will fetch the name of the license as well as a link to it.
     */
    public static function completeLicenseInfo(array $license, object $cacheService): array
    {
        $key = serialize($license);

        return $cacheService->get($key, function (ItemInterface $item) use ($license): array {
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
            'id'   => $authorClass::id,
            'url'  => $authorClass::url,
        ];
    }
}
