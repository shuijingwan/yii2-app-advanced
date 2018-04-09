<?php
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=yii2advanced_test',
            ]
        ],
    ]
);

// 删除 contentNegotiator 组件
$bootstrapKey = array_search('contentNegotiator', $config['bootstrap']);
unset($config['bootstrap'][$bootstrapKey]);
unset($config['components']['contentNegotiator']);

return $config;
