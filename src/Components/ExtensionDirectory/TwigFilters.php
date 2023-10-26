<?php

namespace ExtensionDirectory;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFilters extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('repoType', [Tools::class, 'getRepoType']),
            new TwigFilter('repoName', [Tools::class, 'getRepoName']),
        ];
    }
}
