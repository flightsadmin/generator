<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Class Boilerplate.
 */
class Boilerplate extends BaseConfig
{
    //--------------------------------------------------------------------------
    // App name
    //--------------------------------------------------------------------------

    public $appName = 'Boilerplate';

    //--------------------------------------------------------------------------
    // Dashboard controller
    //--------------------------------------------------------------------------

    public $dashboard = [
        'namespace'  => 'App',
        'controller' => 'Dashboard::index',
        'filter'     => 'auth',
    ];

    public $theme = [
        'body-sm' => false,
        'navbar'  => [
            'bg'     => 'white',
            'type'   => 'light',
            'border' => true,
            'user'   => [
                'visible' => true,
                'shadow'  => 0,
            ],
        ],
        'sidebar' => [
            'type'    => 'dark',
            'shadow'  => 4,
            'border'  => false,
            'compact' => true,
            'links'   => [
                'bg'     => 'blue',
                'shadow' => 1,
            ],
            'brand' => [
                'bg'   => 'gray-dark',
                'logo' => [
                    'icon'   => 'favicon.ico',
                    'text'   => '<strong>Bo</strong>ilerplate',
                    'shadow' => 2,
                ],
            ],
            'user' => [
                'visible' => true,
                'shadow'  => 2,
            ],
        ],
        'footer' => [
            'fixed'      => false,
            'vendorname' => 'Your Awesome Vendor',
            'vendorlink' => 'https://your-awesome.com',
        ],
    ];
}
