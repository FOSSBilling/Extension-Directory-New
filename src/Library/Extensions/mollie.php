<?php

namespace ExtensionDirectory\Extensions;

class mollie
{
    const displayName = 'Mollie';
    const type = 'payment-gateway';
    const description = 'Mollie extension for FOSSBilling';
    const license = 'Apache-2.0';
    const readmeUrl = 'https://raw.githubusercontent.com/FOSSBilling/Mollie/main/README.md';
    const source = [
        'type' => 'github',
        'repo' => 'FOSSBilling/mollie'
    ];
    const website = 'https://fossbilling.org';
    const icon_url = 'https://raw.githubusercontent.com/FOSSBilling/Mollie/main/src/Mollie.png';

    const releases = [
        [
            "tag" => "0.0.3",
            "date" => "2023-06-13T14:17:49Z",
            "download_url" => "https://github.com/FOSSBilling/Mollie/releases/download/0.0.3/Mollie.zip",
            "changelog_url" => "https://github.com/FOSSBilling/Mollie/releases/tag/0.0.3",
            "min_fossbilling_version" => "0.5",
        ],
        [
            "tag" => "0.0.2",
            "date" => "2023-05-08T20:14:07Z",
            "download_url" => "https://github.com/FOSSBilling/Mollie/releases/download/0.0.2/Mollie.zip",
            "changelog_url" => "https://github.com/FOSSBilling/Mollie/releases/tag/0.0.2",
            "min_fossbilling_version" => "0.1",
        ],
        [
            "tag" => "0.0.1",
            "date" => "2023-05-08T17:16:01Z",
            "download_url" => "https://github.com/FOSSBilling/Mollie/releases/download/0.0.1/Mollie.zip",
            "changelog_url" => "https://github.com/FOSSBilling/Mollie/releases/tag/0.0.1",
            "min_fossbilling_version" => "0.1",
        ],
    ];

    public static function getAuthor()
    {
        return new \ExtensionDirectory\Authors\FOSSBilling;
    }
}
