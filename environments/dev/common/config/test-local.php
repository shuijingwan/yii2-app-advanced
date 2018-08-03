<?php
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=g-s-yii2-app-advanced-test',
                'username' => 'g-s-yii2-app-advanced-test',
                'password' => '9dIXzEvrGN9akpcO',
                'charset' => 'utf8mb4',
            ]
        ],
    ]
);
