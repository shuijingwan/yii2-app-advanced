<?php
/**
 * Created by PhpStorm.
 * User: WangQiang
 * Date: 2018/08/02
 * Time: 10:56
 */

namespace rpc\modules\v1\models;


class Page extends \rpc\models\Page
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
