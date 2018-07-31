<?php
/**
 * Created by PhpStorm.
 * User: WangQiang
 * Date: 2018/07/31
 * Time: 13:04
 */

namespace api\modules\v1\models;


class Page extends \api\models\Page
{
    /**
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}
