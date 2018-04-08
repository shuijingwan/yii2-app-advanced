<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['contentNegotiator'],
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath'=>'@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'error' => 'error.php',
                        'success' => 'success.php',
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
