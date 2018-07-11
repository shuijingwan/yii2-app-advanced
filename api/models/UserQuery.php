<?php
/**
 * Created by PhpStorm.
 * User: WangQiang
 * Date: 2018/07/11
 * Time: 16:07
 */

namespace api\models;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends \common\logics\UserQuery
{
    // 默认加上一些条件(不等于 状态：禁用)
    public function init()
    {
        $this->andWhere(['!=', 'status', User::STATUS_DISABLED]);
        parent::init();
    }
}
