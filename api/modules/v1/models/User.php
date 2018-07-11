<?php
/**
 * Created by PhpStorm.
 * User: WangQiang
 * Date: 2018/04/04
 * Time: 16:04
 */

namespace api\modules\v1\models;


class User extends \api\models\User
{
    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
