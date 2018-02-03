<?php
use Zend\Captcha\ReCaptcha;

return [
    'general'           => [
        'name'          => 'Ragnarok Online',
        'from_email'    => 'admin@ragnarok.online',
        'from_name'     => 'Ragnarok Online Administrator',
    ],
    'map-server'    => [
        'address'   => '192.168.1.1',
        'port'      => 6900,
        'timeout'   => 1,
    ],
    'char-server'   => [
        'address'   => '192.168.1.1',
        'port'      => 6900,
        'timeout'   => 1,
    ],
    'login-server'  => [
        'address'   => '192.168.1.1',
        'port'      => 6900,
        'timeout'   => 1,
    ],

    'database' => [
        'driver'    => 'pdo_mysql',
        'database'  => 'ragnarok',
        'username'  => 'root',
        'password'  => '',
        'hostname'  => 'localhost',
        'port'      => '3306',
        'charset'   => 'utf8',
    ],

    'captcha' => [
        'class'     => ReCaptcha::class,
        'options'   => [
            'secret_key'    => 'YOUR_SECRET_KEY',
            'site_key'      => 'YOUR_SITE_KEY',
        ],
    ],
];
