<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['errorHandler', 'log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'd3N9QmpU1fGqAG3DfnwSMR1LnZlXD23B',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->statusCode != 200) {
                    if ($response->statusCode == 400) {
                        $response->statusCode = 200;
                        $response->data = [
                            'status' => 'ERROR',
                            'code' => (isset($response->data['message'])) ? $response->data['message'] : 'UNKNOWN ERROR',
                            'msg' => 'Системная ошибка',
                        ];
                    } else {
                        Yii::error('Получили ошибку в ответе от сервера: statusCode=' . serialize($response->statusCode) . ' :: data=' . serialize($response->data), 'ResponseBeforeSend');
                        $response->statusCode = 200;
                        $response->data = [
                            'status' => 'ERROR',
                            'code' => (isset($response->data['message'])) ? $response->data['message'] : 'UNKNOWN ERROR',
                            'msg' => 'Системная ошибка',
                        ];
                    }

                }
                if ($response->data === null) {
                    Yii::error('Получили пустой ответ после обработки!', 'ResponseBeforeSend');
                    $response->data = [
                        'status' => 'ERROR',
                        'code' => 'EMPTY ANSWER',
                        'msg' => 'Пустой ответ',
                    ];
                }
                Yii::info('Отправлено: status=' . serialize($response->statusCode) . ' :: data=' . serialize($response->data), 'ResponseBeforeSend');
            }
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'class' => 'app\components\helper\error\Handler',
            'errorAction' => 'api/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'Sessions' => [
            'class' => 'app\components\Session\Sessions'
        ]

    ],
    'params' => $params,
    'on beforeRequest' => function () {
        Yii::debug('Начало запроса', 'AppBeginRequest');
    },
    'on afterRequest' => function () {
        Yii::debug('Окончание запроса', 'AppEndRequest');
    }
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
