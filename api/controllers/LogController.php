<?php
/**
 * Created by PhpStorm.
 * User: WangQiang
 * Date: 2018/06/21
 * Time: 15:29
 */

namespace api\controllers;

use yii\rest\ActiveController;

class LogController extends ActiveController
{
    public $serializer = [
        'class' => 'api\rests\log\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        // 禁用"create"、"update"、"delete"、"options"动作
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['options']);
        $actions['index']['class'] = 'api\rests\log\IndexAction';
        $actions['view']['class'] = 'api\rests\log\ViewAction';
        return $actions;
    }
}
