<?php

namespace ExtensionDirectory\Extensions;

class razorpay
{
    const name = 'Razorpay';
    const type = 'payment-gateway';
    const description = 'Razorpay extension for FOSSBilling';
    const license = [
        'id'  => 'apache-2.0',
        'url' => 'https://github.com/albinvar/Razorpay-FOSSBilling/blob/1.x-prod/LICENSE'
    ];
    const readmeUrl = 'https://raw.githubusercontent.com/albinvar/Razorpay-FOSSBilling/1.x-prod/README.md';
    const repo = 'https://github.com/albinvar/Razorpay-FOSSBilling';
    const website = 'https://razorpay.com';
    const icon_url = 'https://raw.githubusercontent.com/albinvar/assets/main/fossbilling/razorpay-glyph-cropped.svg';

    const author = 'Albinvar';

    const releases = [
        [
            'tag' => '0.1.0',
            'date' => '2023-09-24T21:03:30Z',
            'download_url' => 'https://github.com/albinvar/Razorpay-FOSSBilling/releases/download/v0.1.0/Razorpay.zip',
            'changelog_url' => 'https://github.com/albinvar/Razorpay-FOSSBilling/releases/tag/v0.1.0',
            'min_fossbilling_version' => '0.5',
        ]
    ];
}
