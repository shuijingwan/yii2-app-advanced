<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2018/06/21
 * Time: 15:53
 */

namespace api\modules\v1\models;


class Log extends \api\models\Log
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
