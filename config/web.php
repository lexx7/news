<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'events'],
    'components' => require(__DIR__ . '/components.php'),
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'budyaga\users\Module',
            'userPhotoUrl' => 'http://example.com/uploads/user/photo',
            'userPhotoPath' => '@web/uploads/user/photo'
        ],
        'news' => [
            'class' => 'app\modules\news\Module',
        ],
        'events' => [
            'class' => 'app\modules\events\Module',
        ],
        'customer-user' => [
            'class' => 'app\modules\user\Module',
        ],
        'barcode' => [
            'class' => 'app\modules\barcode\Module',
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*', '192.168.10.*'],
    ];
}

return $config;
