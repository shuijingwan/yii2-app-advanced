<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2019/10/08
 * Time: 13:48
 */

namespace common\logics;

use Yii;

/**
 * This is the model class for table "{{%log}}".
 */
class Log extends \common\models\Log
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
