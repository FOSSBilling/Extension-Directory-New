<?php

namespace ExtensionDirectory;

use Symfony\Contracts\Cache\ItemInterface;

class BadgeBuilder
{

    public static function buildABadge(string $id, string $type, object $cacheService, ?string $color = null): string
    {
        $key = serialize([$id, $type, $color]);

        return $cacheService->get($key, function (ItemInterface $item) use ($id, $type, $color, $cacheService): string {
            $item->expiresAfter(86400); // Retain this cache for one day

            $extension = ExtensionInfo::getExtensionInfo($id, false, $cacheService);

            if (!$extension) {
                // Reduced cache length if there was an error so it can ideally self-resolve
                $item->expiresAfter(1800);
                return '';
            }

            $color ??= 'blue';

            switch (strtolower($type)) {
                case 'version':
                    $badgeUrl = "https://shields.io/badge/Latest_version-v{$extension['version']}-{$color}";
                    break;
                case 'min_fossbilling_version':
                    $minFossBillingVersion = $extension['releases'][0]['min_fossbilling_version'];
                    $badgeUrl = "https://shields.io/badge/Minimum_FOSSBilling_Version-v{$minFossBillingVersion}-{$color}";
                    break;
                case 'license':
                    $licenseName = $extension['license']['name'];
                    $badgeUrl = "https://shields.io/badge/Licence-{$licenseName}-{$color}";
                    break;
                default:
                    return '';
            }

            return file_get_contents($badgeUrl);
        });
    }
}
