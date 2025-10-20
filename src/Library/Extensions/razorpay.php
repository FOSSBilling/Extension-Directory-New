<?php

namespace ExtensionDirectory\Extensions;

class razorpay
{
    public const NAME = 'Razorpay';
    public const TYPE = 'payment-gateway';
    public const DESCRIPTION = 'Razorpay extension for FOSSBilling';
    public const LICENSE = [
        'id'  => 'apache-2.0',
        'url' => 'https://github.com/albinvar/Razorpay-FOSSBilling/blob/1.x-prod/LICENSE'
    ];
    public const README_URL = 'https://raw.githubusercontent.com/albinvar/Razorpay-FOSSBilling/1.x-prod/README.md';
    public const REPO = 'https://github.com/albinvar/Razorpay-FOSSBilling';
    public const WEBSITE = 'https://razorpay.com';
    public const ICON_URL = 'https://raw.githubusercontent.com/albinvar/assets/main/fossbilling/razorpay-glyph-cropped.svg';

    public const AUTHOR = 'Albinvar';

    public const RELEASES = [
        [
            'tag' => '0.1.0',
            'date' => '2023-09-24T21:03:30Z',
            'download_url' => 'https://github.com/albinvar/Razorpay-FOSSBilling/releases/download/v0.1.0/Razorpay.zip',
            'changelog_url' => 'https://github.com/albinvar/Razorpay-FOSSBilling/releases/tag/v0.1.0',
            'min_fossbilling_version' => '0.5',
        ]
    ];
}
