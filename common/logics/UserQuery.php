<?php

namespace common\logics;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends \common\models\UserQuery
{
    // 不等于 状态：删除
    public function notDeleted()
    {
        $this->andWhere(['!=', 'status', User::STATUS_DELETED]);
    }

    // 等于 状态：禁用
    public function disabled()
    {
        return $this->andWhere(['status' => User::STATUS_DISABLED]);
    }

    // 等于 状态：启用
    public function enabled()
    {
        return $this->andWhere(['status' => User::STATUS_ENABLED]);
    }
}
