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
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
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
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'categories' => [
                        'common\behaviors\RequestLogBehavior::afterRequest',
                    ],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userId = $user ? $user->getId(false) : '-';
                        return sprintf('[%s][%s][%s]', Yii::$app->id, $url, $userId);
                    },
                    'logVars' => [],
                ]
            ],
        ],
        'urlManager' => require __DIR__ . '/urlManager.php',
        'contentNegotiator' => [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => yii\web\Response::FORMAT_JSON,
                'application/xml' => yii\web\Response::FORMAT_XML,
            ],
            'languages' => [
                'zh-CN',
                'en-US',
            ],
        ],
    ],
    'as requestLog' => [
        'class' => common\behaviors\RequestLogBehavior::class,
    ],
    'modules' => [
        'v1' => [
            'class' => api\modules\v1\Module::class,
        ],
    ],
    'params' => $params,
];
