<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.06.2016
 * Time: 18:45
 */

return [
    'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'ouef9h97hsd9qhd9qdh9hg9ggytf54d',
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'user' => [
        'identityClass' => 'budyaga\users\models\User',
        'enableAutoLogin' => true,
        'loginUrl' => ['/login'],
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => true,
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ],
        ],
    ],
    'db' => require(__DIR__ . '/db.php'),
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            '/signup' => '/user/user/signup',
            '/login' => '/user/user/login',
            '/logout' => '/user/user/logout',
            '/requestPasswordReset' => '/user/user/request-password-reset',
            '/resetPassword' => '/user/user/reset-password',
            '/profile' => '/customer-user/user/profile',
            '/retryConfirmEmail' => '/user/user/retry-confirm-email',
            '/confirmEmail' => '/user/user/confirm-email',
            '/unbind/<id:[\w\-]+>' => '/user/auth/unbind',
            '/oauth/<authclient:[\w\-]+>' => '/user/auth/index'
        ],
    ],
    'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
    ],
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
];