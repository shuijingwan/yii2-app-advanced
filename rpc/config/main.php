<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-rpc',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'contentNegotiator'],
    'controllerNamespace' => 'rpc\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-rpc',
        ],
        'user' => [
            'identityClass' => 'rpc\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-rpc', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the rpc
            'name' => 'advanced-rpc',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'contentNegotiator' => [
            'class' => 'yii\filters\ContentNegotiator',
            'languages' => [
                'en-US',
                'zh-CN',
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
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
                    'basePath'=>'@rpc/messages',
                    'fileMap'=>[
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => rpc\modules\v1\Module::class,
        ],
    ],
    'params' => $params,
];
