<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2020/06/28
 * Time: 15:14
 */

namespace common\filters;

use Yii;
use Hprose\Filter;

/**
 * Hprose 过滤器
 * @package common\filters
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class HproseFilter implements Filter
{
    /**
     * @param $data
     * @param $context
     * @return mixed
     */
    public function inputFilter($data, $context) {
        error_log($data);
        return $data;
    }

    /**
     * @param $data
     * @param $context
     * @return mixed
     */
    public function outputFilter($data, $context) {
        error_log($data);
        return $data;
    }
}
