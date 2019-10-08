<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2019/10/08
 * Time: 13:40
 */

namespace console\models;

class Log extends \common\logics\Log
{
    /**
     * {@inheritdoc}
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }
}
