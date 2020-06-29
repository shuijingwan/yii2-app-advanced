<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2018/08/02
 * Time: 13:12
 */

namespace common\logics\rpc;

use Yii;
use Hprose\Http\Client;

/**
 * RPC 客户端的基础类
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class Model extends \yii\base\Model
{
    /**
     * 创建一个同步的 HTTP 客户端
     *
     * @param string $controllerId 控制器ID
     * 格式如下：
     * page
     *
     * @param string $actionId 方法ID
     * 格式如下：
     * create
     *
     * @return mixed $client 同步的 HTTP 客户端
     * @throws \Exception
     */
    public static function client($controllerId, $actionId)
    {
        $url = Yii::$app->params['rpc']['hostInfo'] . Yii::$app->params['rpc']['baseUrl'];
        $client = Client::create($url . '/' . $controllerId . '/' . $actionId, false);
        return $client->$controllerId;
    }
}
