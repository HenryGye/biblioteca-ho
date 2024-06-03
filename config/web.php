<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$mongodb = require __DIR__ . '/mongodb.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9EGKcsi21QZXvhrwsb4_CU4IzrLvmjeO',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            // 'errorAction' => 'site/error',
            'class' => 'app\components\ErrorHandler',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
        //'db' => $db,
        'mongodb' => $mongodb,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'libro'],
                // rutas para libros
                'GET libros' => 'libro/listar',
                'GET libros/<id:>' => 'libro/listar-por-id',
                'POST libros' => 'libro/registrar',
                'PUT libros/<id:>' => 'libro/actualizar',
                'DELETE libros/<id:>' => 'libro/eliminar',
                // rutas para autores
                'GET autores' => 'autor/listar',
                'GET autores/<id:>' => 'autor/listar-por-id',
                'POST autores' => 'autor/registrar',
                'PUT autores/<id:>' => 'autor/actualizar',
                'DELETE autores/<id:>' => 'autor/eliminar',
                // ruta generar token
                'GET generate-token' => 'token/generate-token',
            ],
        ],
        'jwtAuth' => [
            'class' => 'app\components\JwtAuth',
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
