<?php

namespace ExtensionDirectory;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFilters extends AbstractExtension
{
    public function __construct(
        private readonly Tools $tools
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('repoType', [$this->tools, 'getRepoType']),
            new TwigFilter('repoName', [$this->tools, 'getRepoName']),
        ];
    }
}
