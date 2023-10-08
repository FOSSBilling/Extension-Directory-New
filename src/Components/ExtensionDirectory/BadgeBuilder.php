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
                return '';
            }

            // Default color
            $color ??= 'blue';

            switch (strtolower($type)) {
                case 'version':
                    $base = 'https://shields.io/badge/Latest_version-v:version:-:color:';
                    return file_get_contents(strtr($base, [':version:' => $extension['version'], ':color:' => $color]));
                case 'min_fossbilling_version':
                    $base = 'https://shields.io/badge/Minimum_FOSSBilling_Version-v:version:-:color:';
                    return file_get_contents(strtr($base, [':version:' => $extension['releases'][0]['min_fossbilling_version'], ':color:' => $color]));
                    break;
                case 'license':
                    $base = 'https://shields.io/badge/Licence-:licence:-:color:';
                    return file_get_contents(strtr($base, [':licence:' => $extension['license']['name'], ':color:' => $color]));
                    break;
                default:
                    return '';
            }
        });
    }
}
