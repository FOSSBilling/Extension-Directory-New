<?php

namespace ExtensionDirectory\Extensions;

class bitcart
{
    public const NAME = 'Bitcart';
    public const TYPE = 'payment-gateway';
    public const DESCRIPTION = 'Bitcart extension for FOSSBilling';
    public const LICENSE = [
        'id'  => 'MIT',
        'url' => 'https://github.com/bitcart/bitcart-fossbilling/blob/master/LICENSE'
    ];
    public const README_URL = 'https://raw.githubusercontent.com/bitcart/bitcart-fossbilling/master/README.md';
    public const REPO = 'https://github.com/bitcart/bitcart-fossbilling';
    public const WEBSITE = 'https://bitcart.ai/';
    public const ICON_URL = 'https://raw.githubusercontent.com/bitcart/bitcart-fossbilling/master/Bitcart/Bitcart.png';

    public const AUTHOR = 'Bitcart';

    public const RELEASES = [
        [
            'tag' => '1.1.0',
            'date' => '2023-06-15T19:22:52Z',
            'download_url' => 'https://github.com/bitcart/bitcart-fossbilling/releases/download/1.1.0/Bitcart.zip',
            'changelog_url' => 'https://github.com/bitcart/bitcart-fossbilling/releases/tag/1.1.0',
            'min_fossbilling_version' => '0.5',
        ],
        [
            'tag' => '1.0.0',
            'date' => '2023-05-15T19:22:52Z',
            'download_url' => 'https://github.com/bitcart/bitcart-fossbilling/releases/download/1.0.0/BitcartCC.zip',
            'changelog_url' => 'https://github.com/bitcart/bitcart-fossbilling/releases/tag/1.0.0',
            'min_fossbilling_version' => '0.1',
        ],
    ];
}
