<?php

namespace ExtensionDirectory;

use Symfony\Contracts\Cache\ItemInterface;

class BadgeBuilder
{
    public const wwwIcon = '<?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="122.88px" height="122.88px" viewBox="0 0 122.88 122.88" enable-background="new 0 0 122.88 122.88" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M61.439,0c33.928,0,61.44,27.513,61.44,61.439c0,33.929-27.513,61.44-61.44,61.44 C27.512,122.88,0,95.368,0,61.439C0,27.513,27.512,0,61.439,0L61.439,0z M78.314,6.495c20.618,6.853,36.088,24.997,39.068,47.101 l-1.953-0.209c-0.347,1.495-0.666,1.533-0.666,3.333c0,1.588,2,2.651,2,6.003c0,0.898-2.109,2.694-2.202,3.007l-3.132-3.674v4.669 l-0.476-0.018l-0.844-8.615l-1.749,0.551l-2.081-6.409l-6.855,7.155l-0.082,5.239l-2.238,1.501l-2.377-13.438l-1.422,1.039 l-3.22-4.345l-4.813,0.143l-1.844-2.107l-1.887,0.519l-3.712-4.254l-0.717,0.488l2.3,5.878h2.669v-1.334h1.333 c0.962,2.658,2.001,1.084,2.001,2.669c0,5.547-6.851,9.625-11.339,10.669c0.24,1.003,0.147,2.003,1.333,2.003 c2.513,0,1.264-0.44,4.003-0.667c-0.127,5.667-6.5,12.435-9.221,16.654l1.218,8.69c0.321,1.887-3.919,3.884-5.361,6.009 l0.692,3.329l-1.953,0.789c-0.342,3.42-3.662,7.214-7.386,7.214h-4c0-4.683-3.336-11.366-3.336-14.675 c0-2.81,1.333-3.188,1.333-6.669c0-3.216-3.333-7.828-3.333-8.67v-5.336h-2.669c-0.396-1.487-0.154-2-2-2h-0.667 c-2.914,0-2.422,1.333-5.336,1.333h-2.669c-2.406,0-6.669-7.721-6.669-8.671v-8.003c0-3.454,3.161-7.214,5.336-8.672v-3.333 l3.002-3.052l1.667-0.284c3.579,0,3.154-2,5.336-2H49.4v4.669L56,43.532l0.622-2.848c2.991,0.701,3.769,2.032,7.454,2.032h1.333 c2.531,0,2.667-3.358,2.667-6.002l-5.343,0.528l-2.324-5.064l-2.311,0.615c0.415,1.812,0.642,1.059,0.642,2.587 c0,0.9-0.741,1-1.335,1.334l-2.311-5.865l-4.969-3.549l-0.66,0.648l4.231,4.452c-0.562,1.597-0.628,6.209-2.961,2.979l2.182-1.05 l-5.438-5.699l-3.258,1.274l-3.216,3.08c-0.336,2.481-1.012,3.729-3.608,3.729c-1.728,0-0.685-0.447-3.336-0.667v-6.669h6.002 l-1.945-4.442l-0.721,0.44V24.04l9.747-4.494c-0.184-1.399-0.408-0.649-0.408-2.175c0-0.091,0.655-1.322,0.667-1.336l2.521,1.565 l-0.603-2.871l-3.889,0.8l-0.722-3.49c3.084-1.624,9.87-7.34,12.028-7.34h2.002c2.107,0,7.751,2.079,8.669,3.333L62.057,7.49 l3.971,3.271l0.381-1.395l2.964-0.812l0.036-1.855h1.336v2L78.314,6.495L78.314,6.495z M116.963,71.835 c-0.154,0.842-0.324,1.676-0.512,2.504l-0.307-2.152L116.963,71.835L116.963,71.835z M115.042,79.398 c-0.147,0.446-0.297,0.894-0.455,1.336h-0.49v-1.336H115.042L115.042,79.398z M11.758,93.18 c-3.624-5.493-6.331-11.641-7.916-18.226l10.821,5.218l0.055,3.229c0,1.186-2.025,3.71-2.667,4.669L11.758,93.18L11.758,93.18z"/></g></svg>';
    public const authorIrcon = '<?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 121.48 122.88" style="enable-background:new 0 0 121.48 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M96.84,2.22l22.42,22.42c2.96,2.96,2.96,7.8,0,10.76l-12.4,12.4L73.68,14.62l12.4-12.4 C89.04-0.74,93.88-0.74,96.84,2.22L96.84,2.22z M70.18,52.19L70.18,52.19l0,0.01c0.92,0.92,1.38,2.14,1.38,3.34 c0,1.2-0.46,2.41-1.38,3.34v0.01l-0.01,0.01L40.09,88.99l0,0h-0.01c-0.26,0.26-0.55,0.48-0.84,0.67h-0.01 c-0.3,0.19-0.61,0.34-0.93,0.45c-1.66,0.58-3.59,0.2-4.91-1.12h-0.01l0,0v-0.01c-0.26-0.26-0.48-0.55-0.67-0.84v-0.01 c-0.19-0.3-0.34-0.61-0.45-0.93c-0.58-1.66-0.2-3.59,1.11-4.91v-0.01l30.09-30.09l0,0h0.01c0.92-0.92,2.14-1.38,3.34-1.38 c1.2,0,2.41,0.46,3.34,1.38L70.18,52.19L70.18,52.19L70.18,52.19z M45.48,109.11c-8.98,2.78-17.95,5.55-26.93,8.33 C-2.55,123.97-2.46,128.32,3.3,108l9.07-32v0l-0.03-0.03L67.4,20.9l33.18,33.18l-55.07,55.07L45.48,109.11L45.48,109.11z M18.03,81.66l21.79,21.79c-5.9,1.82-11.8,3.64-17.69,5.45c-13.86,4.27-13.8,7.13-10.03-6.22L18.03,81.66L18.03,81.66z"/></g></svg>';
    
    public static function buildABadge(string $id, string $type, object $cacheService, ?string $color = null): string
    {
        $key = serialize([$id, $type, $color]);

        return $cacheService->get($key, function (ItemInterface $item) use ($id, $type, $color, $cacheService): string {
            $item->expiresAfter(3600); // Cached for an hour just to reduce load on shields.io

            $extension = ExtensionManager::getExtensionInfo($id, false, $cacheService);

            if (!$extension) {
                // Reduced cache length if there was an error so it can ideally self-resolve
                $item->expiresAfter(900);
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
                case 'repo_type_1':
                    $repoUrl = $extension['repo'];
                    $logo = Tools::getRepoType($repoUrl);
                    $badgeUrl = "https://shields.io/badge/Repository-Soure_Code-{$color}?logo={$logo}";
                    break;
                case 'repo_type_2':
                    $repoUrl = $extension['repo'];
                    $logo = Tools::getRepoType($repoUrl);
                    $repo = str_replace('-', '--', Tools::getRepoName($repoUrl));
                    $badgeUrl = "https://shields.io/badge/Repository-$repo-{$color}?logo={$logo}";
                    break;
                case 'author':
                    $author = $extension['author']['name'];
                    $author = str_replace('-', '--', Tools::getRepoName($author));
                    $author = str_replace('_', '__', Tools::getRepoName($author));
                    // Shields.io allows custom logos if we base it base64 encoded, so we do so here
                    $logo   = 'data:image/svg%2bxml;base64,' . base64_encode(self::authorIrcon);
                    $badgeUrl = "https://shields.io/badge/Author-$author-{$color}?logo={$logo}&logoColor=white";
                    break;
                case 'website':
                    $website = $extension['website'];
                    $hostname = parse_url($website)['host'];
                    // Shields.io allows custom logos if we base it base64 encoded, so we do so here
                    $logo   = 'data:image/svg%2bxml;base64,' . base64_encode(self::wwwIcon);
                    $badgeUrl = "https://shields.io/badge/Website-{$hostname}-{$color}?logo={$logo}&logoColor=white";
                    break;
                default:
                    return '';
            }

            $badgeUrl = str_replace(' ', '%20', $badgeUrl);
            return file_get_contents($badgeUrl);
        });
    }
}
