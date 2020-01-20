<?php
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=gsy2aa-test',
                'username' => 'gsy2aa-test',
                'password' => '9dIXzEvrGN9akpcO',
                'charset' => 'utf8mb4',
            ]
        ],
    ]
);
