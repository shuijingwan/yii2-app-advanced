<?php
return [
    'class' => yii\web\UrlManager::class,
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => ['v1/user'],
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => ['v1/log'],
            'only' => ['index', 'view'],
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => ['v1/page'],
        ],
    ],
];
