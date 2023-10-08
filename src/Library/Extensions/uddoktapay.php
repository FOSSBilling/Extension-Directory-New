<?php

namespace ExtensionDirectory\Extensions;

class uddoktapay
{
    const name = 'UddoktaPay';
    const type = 'payment-gateway';
    const description = 'UddoktaPay extension for FOSSBilling';
    const license = [
        'id'  => 'MIT',
        'URL' => 'https://github.com/UddoktaPay/FOSSBilling/blob/master/LICENSE'
    ];
    const readmeUrl = 'https://raw.githubusercontent.com/UddoktaPay/FOSSBilling/main/README.md';
    const source = [
        'type' => 'github',
        'repo' => 'UddoktaPay/FOSSBilling'
    ];
    const website = 'https://uddoktapay.com';
    const icon_url = 'https://raw.githubusercontent.com/UddoktaPay/FOSSBilling/master/UddoktaPay/UddoktaPay.png';

    const author = 'UddoktaPay';

    const releases = [
        [
            'tag' => '1.0.0',
            'date' => '2023-07-29T11:44:14Z',
            'download_url' => 'https://github.com/UddoktaPay/FOSSBilling/releases/download/1.0.0/UddoktaPay.zip',
            'changelog_url' => 'https://github.com/UddoktaPay/FOSSBilling/releases/tag/1.0.0',
            'min_fossbilling_version' => '0.5',
        ]
    ];
}
