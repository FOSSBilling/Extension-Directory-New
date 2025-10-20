<?php

namespace ExtensionDirectory\Extensions;

class uddoktapay
{
    public const NAME = 'UddoktaPay';
    public const TYPE = 'payment-gateway';
    public const DESCRIPTION = 'UddoktaPay extension for FOSSBilling';
    public const LICENSE = [
        'id'  => 'MIT',
        'url' => 'https://github.com/UddoktaPay/FOSSBilling/blob/master/LICENSE'
    ];
    public const README_URL = 'https://raw.githubusercontent.com/UddoktaPay/FOSSBilling/main/README.md';
    public const REPO = 'https://github.com/UddoktaPay/FOSSBilling';
    public const WEBSITE = 'https://uddoktapay.com';
    public const ICON_URL = 'https://raw.githubusercontent.com/UddoktaPay/FOSSBilling/master/UddoktaPay/UddoktaPay.png';

    public const AUTHOR = 'UddoktaPay';

    public const RELEASES = [
        [
            'tag' => '1.0.0',
            'date' => '2023-07-29T11:44:14Z',
            'download_url' => 'https://github.com/UddoktaPay/FOSSBilling/releases/download/1.0.0/UddoktaPay.zip',
            'changelog_url' => 'https://github.com/UddoktaPay/FOSSBilling/releases/tag/1.0.0',
            'min_fossbilling_version' => '0.5',
        ]
    ];
}
