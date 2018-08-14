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
            Yii::$app::EVENT_AFTER_REQUEST => 'afterRequest',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterRequest($event)
    {
        // 请求日志允许记录的请求方法
        if (in_array(Yii::$app->request->method, Yii::$app->params['requestLog']['allowMethod'])) {
            $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : '';
            $requestQueryParams = Yii::$app->getRequest()->getQueryParams();
            $requestBodyParams = Yii::$app->getRequest()->getBodyParams();
            $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
            $userId = $user ? $user->getId(false) : '-';
            $message = [
                'url' => $url,
                'request_query_params' => $requestQueryParams,
                'request_body_params' => $requestBodyParams,
                'user_id' => $userId,
                '$_SERVER' => [
                    'HTTP_ACCEPT_LANGUAGE' => isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '',
                    'HTTP_ACCEPT' => $_SERVER['HTTP_ACCEPT'],
                    'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                    'REMOTE_ADDR' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                    'REQUEST_URI' => $_SERVER['REQUEST_URI'],
                    'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                    'CONTENT_TYPE' => isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '',
                ],
            ];
            Yii::info($message, __METHOD__);
        }
    }
}
