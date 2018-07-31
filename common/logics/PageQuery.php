<?php

namespace common\logics;

/**
 * This is the ActiveQuery class for [[Page]].
 *
 * @see Page
 */
class PageQuery extends \common\models\PageQuery
{
    // 不等于 状态：删除
    public function notDeleted()
    {
        return $this->andWhere(['!=', 'status', Page::STATUS_DELETED]);
    }

    // 等于 状态：禁用
    public function disabled()
    {
        return $this->andWhere(['status' => Page::STATUS_DISABLED]);
    }

    // 等于 状态：草稿
    public function draft()
    {
        return $this->andWhere(['status' => Page::STATUS_DRAFT]);
    }

    // 等于 状态：发布
    public function published()
    {
        return $this->andWhere(['status' => Page::STATUS_PUBLISHED]);
    }
}
