<?php

/* Get frontend-specific config settings from ENV vars or set defaults. */
$FRONT_COOKIE_KEY = getenv('FRONT_COOKIE_KEY') ?: null;

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [], // Disable logging of _SERVER, _POST, etc.
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => $FRONT_COOKIE_KEY,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'workflow',
                    'pluralize' => false,
                    'extraPatterns' => [
                        //'POST' => 'new-workflow',
                        'GET <id>' => 'view-workflow',
                    ]
                ],
            ],
        ]
    ],
    'params' => [],
];
