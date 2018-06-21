<?php
namespace api\behaviors;

use Yii;
use yii\base\Behavior;

/**
 * Class RequestLogBehavior
 * @package api\behaviors
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class RequestLogBehavior extends Behavior
{
    public function events()
    {
        return [
            Yii::$app::EVENT_BEFORE_REQUEST => 'beforeRequest',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeRequest($event)
    {
        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
        $requestQueryParams = Yii::$app->getRequest()->getQueryParams();
        $requestBodyParams = Yii::$app->getRequest()->getBodyParams();
        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
        $userId = $user ? $user->getId(false) : '-';
        $message = [
            'url' => $url,
            'requestQueryParams' => $requestQueryParams,
            'requestBodyParams' => $requestBodyParams,
            'userId' => $userId,
            '$_SERVER' => [
                'HTTP_ACCEPT_LANGUAGE' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                'HTTP_ACCEPT' => $_SERVER['HTTP_ACCEPT'],
                'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
                'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                'CONTENT_TYPE' => $_SERVER['CONTENT_TYPE'],
            ],
        ];
        Yii::info(serialize($message), __METHOD__);
    }
}
