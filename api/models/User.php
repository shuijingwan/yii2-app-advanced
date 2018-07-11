<?php
/**
 * Created by PhpStorm.
 * User: WangQiang
 * Date: 2018/04/04
 * Time: 10:44
 */

namespace api\models;

class User extends \common\logics\User
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
