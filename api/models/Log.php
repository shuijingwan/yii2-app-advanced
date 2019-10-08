<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2018/06/21
 * Time: 15:50
 */

namespace api\models;

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
