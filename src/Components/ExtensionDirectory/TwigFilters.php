<?php

namespace ExtensionDirectory;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFilters extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('repoType', [$this, 'getRepoType']),
            new TwigFilter('repoName', [$this, 'getRepoName']),
        ];
    }

    public static function getRepoType(string $url): string
    {
        $repoHosts = [
            'github.com' => 'github',
            'bitbucket.org' => 'bitbucket',
            'gitlab.com' => 'gitlab',
            'sourceforge.net' => 'sourceforge',
        ];

        foreach ($repoHosts as $host => $type) {
            if (strpos($url, $host) !== false) {
                return $type;
            }
        }

        return 'unknown';
    }

    public static function getRepoName(string $url): string
    {
        $repoHosts = [
            'github.com' => 'https://github.com/',
            'bitbucket.org' => 'https://bitbucket.org/',
            'gitlab.com' => 'https://gitlab.com/',
            'sourceforge.net' => 'https://sourceforge.net/projects/',
        ];

        foreach ($repoHosts as $host => $prefix) {
            if (strpos($url, $host) !== false) {
                $repoName = str_replace($prefix, '', $url);
                return rtrim($repoName, '/');
            }
        }

        return $url;
    }
}
