<?php

namespace common\logics;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends \common\models\UserQuery
{
    // 是否被删除：否
    public function isDeletedNo()
    {
        return $this->andWhere(['is_deleted' => User::IS_DELETED_NO]);
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
