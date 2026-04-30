<?php

namespace ExtensionDirectory\Extensions;

class coinpayportal
{
    public const NAME = 'CoinPayPortal';
    public const TYPE = 'payment-gateway';
    public const DESCRIPTION = 'Accept crypto payments through CoinPayPortal. Customers are redirected to a secure checkout and invoices are automatically marked paid after verified payment confirmation.';
    public const LICENSE = [
        'id' => 'mit'
    ];
    public const README_URL = 'https://raw.githubusercontent.com/profullstack/coinpayportal/master/plugins/fossbilling/README.md';
    public const REPO = 'https://github.com/profullstack/coinpayportal';
    public const WEBSITE = 'https://coinpayportal.com';
    public const ICON_URL = 'https://coinpayportal.com/logo.svg';

    public const AUTHOR = 'CoinPayPortal';

    public const RELEASES = [
        [
            'tag'                    => '1.0.0',
            'date'                   => '2026-04-30T00:00:00Z',
            'download_url'           => 'https://github.com/profullstack/coinpayportal/releases/download/fossbilling-v1.0.0/CoinPayPortal.zip',
            'changelog_url'          => 'https://github.com/profullstack/coinpayportal/releases/tag/fossbilling-v1.0.0',
            'min_fossbilling_version' => '0.6.0',
        ],
    ];
}
