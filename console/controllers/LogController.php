<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2019/10/08
 * Time: 13:36
 */

namespace console\controllers;

use Yii;
use console\models\Log;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * 日志
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since  1.0
 */
class LogController extends Controller
{
    /**
     * 日志的删除
     */
    public function actionDelete()
    {
        /* 获取服务器当前时间，判断范围([3点，5点))，如果不在范围内，则成功退出 */
        $time = time(); // 当前时间
        $threeTime = strtotime("today +3 hours"); // 3点
        $fiveTime = strtotime("today +5 hours"); // 5点
        if (!($time >= $threeTime && $time < $fiveTime)) {
            return ExitCode::OK;
        }

        /* 查询 1 条记录的日志时间($logTime)，基于 日志时间 升序排列，如果不存在，则成功退出 */
        $logItem = Log::find()->select(['log_time'])->orderBy(['log_time' => SORT_ASC])->limit(1)->one();
        if (!isset($logItem)) {
            return ExitCode::OK;
        }
        $logTime = $logItem->log_time;

        /* 获取服务器当前时间的前 15 天(默认值，可自定义)的值($reservedTime：保留时间，0点)，如果 $logTime 大于等于 $reservedTime，则成功退出 */
        $logDeleteReservedTime = Yii::$app->params['logDeleteReservedTime'];
        $reservedTime = strtotime("today -$logDeleteReservedTime days"); // 保留时间，0点
        if ($logTime >= $reservedTime) {
            return ExitCode::OK;
        }

        /* 获取 1 条记录的日志时间($logTime)的后 1 天的值($deadlineTime：截止时间，0点)，如果 $deadlineTime 大于 $reservedTime，则将 $reservedTime 赋值给 $deadlineTime(后 1 天的值时，此条件永远不满足，大于 1 天时，此条件可能满足) */
        $logDate = date('Y-m-d', $logTime);
        $deadlineTime = strtotime("$logDate +1 days"); // 截止时间，0点
        if ($deadlineTime > $reservedTime) {
            $deadlineTime = $reservedTime;
        }

        /* 查询 100 条记录的日志时间($logTime)，条件(日志时间 小于 $deadlineTime)，基于 日志时间 升序排列，如果为空，则成功退出 */
        $deleteLogItems = Log::find()->where(['<', 'log_time', $deadlineTime])->select(['log_time'])->orderBy(['log_time' => SORT_ASC])->limit(100)->all();
        if (empty($deleteLogItems)) {
            return ExitCode::OK;
        }

        /* 执行删除 SQL()，条件(日志时间 小于等于 $deadlineTime)，即命令行 1 次运行仅删除 1 天的前 100 条的日志消息，再成功退出 */
        $count = count($deleteLogItems);
        $deadlineTime = $deleteLogItems[$count-1]->log_time;
        Log::deleteAll(['<=', 'log_time', $deadlineTime]);

        return ExitCode::OK;
    }
}