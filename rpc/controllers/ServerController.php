<?php
/**
 * Created by PhpStorm.
 * User: WangQiang
 * Date: 2018/08/01
 * Time: 18:02
 */

namespace rpc\controllers;

use Yii;
use yii\web\Controller;
use Hprose\Yii\Server;

/**
 * 远程过程调用 HTTP 服务器
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class ServerController extends Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $server = new Server();
        $server->addMethod($action->actionMethod, $this, $action->controller->id . '_' . $action->id);
        $server->start();
    }
}