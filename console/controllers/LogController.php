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
    const SLEEP_TIME = 10 * 60; // 延缓执行 10 * 60 秒
    /**
     * 日志的删除
     */
    public function actionDelete()
    {
        /* 获取服务器当前时间，判断范围([0点，1点])，如果不在范围内，则延缓执行 10 * 60 秒，再退出 */
        $time = time(); // 当前时间
        $zeroTime = strtotime("today"); // 0点
        $oneTime = strtotime("today +1 hours"); // 1点
        if (!($time >= $zeroTime && $time <= $oneTime)) {
            // 延缓执行 10 * 60 秒
            sleep(static::SLEEP_TIME);

            return ExitCode::OK;
        }

        /* 查询 1 条记录的日志时间($logTime)，基于 日志时间 升序排列，如果不存在，则延缓执行 10 * 60 秒，再退出 */
        $logItem = Log::find()->select(['log_time'])->orderBy(['log_time' => SORT_ASC])->limit(1)->one();
        if (!isset($logItem)) {
            // 延缓执行 10 * 60 秒
            sleep(static::SLEEP_TIME);

            return ExitCode::OK;
        }
        $logTime = $logItem->log_time;

        /* 获取服务器当前时间的前 15 天(默认值，可自定义)的值($reservedTime：保留时间，0点)，如果 $logTime 大于等于 $reservedTime，则延缓执行 10 * 60 秒，再退出 */
        $reservedTime = strtotime("today -15 days"); // 保留时间，0点
        if ($logTime >= $reservedTime) {
            // 延缓执行 10 * 60 秒
            sleep(static::SLEEP_TIME);

            return ExitCode::OK;
        }

        /* 获取 1 条记录的日志时间($logTime)的后 1 天的值($deadlineTime：截止时间，0点)，如果 $deadlineTime 大于 $reservedTime，则将 $reservedTime 赋值给 $deadlineTime(后 1 天的值时，此条件永远不满足，大于 1 天时，此条件可能满足) */
        $logDate = date('Y-m-d', $logTime);
        $deadlineTime = strtotime("$logDate +1 days"); // 截止时间，0点
        if ($deadlineTime > $reservedTime) {
            $deadlineTime = $reservedTime;
        }

        /* 执行删除 SQL()，条件(日志时间 小于 $deadlineTime)，即命令行 1 次运行仅删除 1 天的日志消息，延缓执行 60 秒，再退出 */
        Log::deleteAll(['<', 'log_time', $deadlineTime]);
        // 延缓执行 60 秒
        sleep(60);
        return ExitCode::OK;
    }
}