<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'contentNegotiator'],
    'controllerNamespace' => 'api\controllers',
    'version' => '1.0.0',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        'user' => [
            'identityClass' => 'api\models\User',
            'enableSession' => false,
            'loginUrl' => null,
            'enableAutoLogin' => false,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
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
        'urlManager' => require __DIR__ . '/urlManager.php',
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
        ],
        'i18n' => [
            'translations' => [
                'model/*'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath'=>'@common/messages',
                    'fileMap'=>[
                    ],
                ],
                '*'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath'=>'@api/messages',
                    'fileMap'=>[
                    ],
                ],
            ],
        ],
        'contentNegotiator' => [
            'class' => 'yii\filters\ContentNegotiator',
            'languages' => [
                'zh-CN',
                'en-US',
            ],
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => api\modules\v1\Module::class,
        ],
    ],
    'params' => $params,
];
