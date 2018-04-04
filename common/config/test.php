<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\logics\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
    ],
];
