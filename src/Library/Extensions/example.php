<?php

namespace ExtensionDirectory\Extensions;

class example
{
    const displayName = 'Example';
    const type = 'mod';
    const description = 'An example module for developers to get started.';
    const license = [
        'id' => 'apache-2.0'
    ];
    const readmeUrl = 'https://raw.githubusercontent.com/FOSSBilling/example-module/main/README.md';
    const source = [
        'type' => 'github',
        'repo' => 'FOSSBilling/example-module'
    ];
    const website = 'https://fossbilling.org';
    const icon_url = 'https://raw.githubusercontent.com/FOSSBilling/example-module/main/src/icon.svg';

    const author = 'FOSSBilling';

    const releases = [
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
