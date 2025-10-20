<?php

namespace ExtensionDirectory\Extensions;

class mollie
{
    public const NAME = 'Mollie';
    public const TYPE = 'payment-gateway';
    public const DESCRIPTION = 'Mollie extension for FOSSBilling';
    public const LICENSE = [
        'id' => 'apache-2.0'
    ];
    public const README_URL = 'https://raw.githubusercontent.com/FOSSBilling/Mollie/main/README.md';
    public const REPO = 'https://github.com/FOSSBilling/mollie';
    public const WEBSITE = 'https://fossbilling.org';
    public const ICON_URL = 'https://raw.githubusercontent.com/FOSSBilling/Mollie/main/src/Mollie.png';

    public const AUTHOR = 'FOSSBilling';

    public const RELEASES = [
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
}
