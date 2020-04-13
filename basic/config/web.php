<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'defaultRoute' => '/user/site',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'uD4GpEoeIwBh1S9xaJRos7ehpkjmt-_g',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/auth/login'],

        ],
        'errorHandler' => [
            'errorAction' => '/user/site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => 'smtp.inbox.ru',
            //     'username' => 'bogdan-anastasiya@inbox.ru',
            //     'password' => '032ujfw9123',
            //     'port' => '465',
            //     'encryption' => 'ssl',
            // ],
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
        'db' => $db,       
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'register' => 'user/auth/register',
                'login' => 'user/auth/login',
                'retrieve-password' => 'user/auth/retrieve-password',
                'reset_password' => 'user/auth/reset_password',
                'index' => 'user/site/index',
            ],
        ],

        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '716781785512-bnvm9u6n4olcsqemqql1jc4j6luorvpr.apps.googleusercontent.com',
                    'clientSecret' => 'CHgdAa5M96RDxl1bFVaVWHTT',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '411088622893516',
                    'clientSecret' => '01546d40b14891f195a481097429154e',
                    
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '7188680',
                    'clientSecret' => 'eB5pFWF4YuseCqblkvnR',                
                                       
                ],
            
            ],
        ]
        
    ],
    
    'modules' => [
        'admin-panel' => [
            'class' => 'app\modules\adminPanel\Module',
            'defaultRoute' => 'user'
        ],
        'user' => [
            'class' => 'app\modules\user\UserModule',
            
            
        ],
    ],
    
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
