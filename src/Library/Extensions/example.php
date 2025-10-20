<?php

namespace ExtensionDirectory\Extensions;

class example
{
    public const NAME = 'Example';
    public const TYPE = 'mod';
    public const DESCRIPTION = 'An example module for developers to get started.';
    public const LICENSE = [
        'id' => 'apache-2.0'
    ];
    public const README_URL = 'https://raw.githubusercontent.com/FOSSBilling/example-module/main/README.md';
    public const REPO = 'https://github.com/FOSSBilling/example-module';
    public const WEBSITE = 'https://fossbilling.org';
    public const ICON_URL = 'https://raw.githubusercontent.com/FOSSBilling/example-module/main/src/icon.svg';

    public const AUTHOR = 'FOSSBilling';

    public const RELEASES = [
        [
            'tag' => '0.0.5',
            'date' => '2024-02-12T06:36:38+00:00',
            'download_url' => 'https://github.com/FOSSBilling/example-module/releases/download/0.0.5/Example.zip',
            'changelog_url' => 'https://github.com/FOSSBilling/example-module/releases/tag/0.0.5',
            'min_fossbilling_version' => '0.6',
        ],
        [
            'tag' => '0.0.4',
            'date' => '2023-09-25T07:36:29Z',
            'download_url' => 'https://github.com/FOSSBilling/example-module/releases/download/0.0.4/Example.zip',
            'changelog_url' => 'https://github.com/FOSSBilling/example-module/releases/tag/0.0.4',
            'min_fossbilling_version' => '0.5',
        ],
        [
            'tag' => '0.0.3',
            'date' => '2023-06-13T14:11:11Z',
            'download_url' => 'https://github.com/FOSSBilling/example-module/releases/download/0.0.3/Example.zip',
            'changelog_url' => 'https://github.com/FOSSBilling/example-module/releases/tag/0.0.3',
            'min_fossbilling_version' => '0.5',
        ],
        [
            'tag' => '0.0.2',
            'date' => '2023-05-01T08:05:02Z',
            'download_url' => 'https://github.com/FOSSBilling/example-module/releases/download/0.0.2/Example.zip',
            'changelog_url' => 'https://github.com/FOSSBilling/example-module/releases/tag/0.0.2',
            'min_fossbilling_version' => '0.1',
        ],
        [
            'tag' => '0.0.1',
            'date' => '2023-03-31T08:21:28Z',
            'download_url' => 'https://github.com/FOSSBilling/example-module/releases/download/0.0.1/Example.zip',
            'changelog_url' => 'https://github.com/FOSSBilling/example-module/releases/tag/0.0.1',
            'min_fossbilling_version' => '0.1',
        ],
    ];
}
