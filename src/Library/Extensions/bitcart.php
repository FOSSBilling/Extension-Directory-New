<?php

namespace ExtensionDirectory\Extensions;

class bitcart
{
    const name = 'Bitcart';
    const type = 'payment-gateway';
    const description = 'Bitcart extension for FOSSBilling';
    const license = [
        'id'  => 'MIT',
        'URL' => 'https://github.com/bitcart/bitcart-fossbilling/blob/master/LICENSE'
    ];
    const readmeUrl = 'https://raw.githubusercontent.com/bitcart/bitcart-fossbilling/master/README.md';
    const source = [
        'type' => 'github',
        'repo' => 'bitcart/bitcart-fossbilling'
    ];
    const website = 'https://bitcart.ai/';
    const icon_url = 'https://raw.githubusercontent.com/bitcart/bitcart-fossbilling/master/Bitcart/Bitcart.png';

    const author = 'Bitcart';

    const releases = [
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
