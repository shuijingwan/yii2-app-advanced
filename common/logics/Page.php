<?php

namespace common\logics;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use common\behaviors\UUIDBehavior;
use yii\helpers\ArrayHelper;

class Page extends \common\models\Page
{
    const STATUS_DISABLED = 0; //状态：禁用
    const STATUS_DRAFT = 1; //状态：草稿
    const STATUS_PUBLISHED = 2; //状态：发布

    const IS_DELETED_NO = 0; //是否被删除：否
    const IS_DELETED_YES = 1; //是否被删除：是

    const DELETED_AT_DEFAULT = 0; //删除时间：默认值

    const SCENARIO_CREATE = 'create';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ]
            ],
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true
            ],
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'uuid',
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_deleted' => self::IS_DELETED_YES,
                    'deleted_at' => function ($model) {
                        return time();
                    },
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['slug', 'title', 'body', 'view', 'status'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['title', 'body'], 'required'],
            [['slug'], 'unique'],
            ['view', 'default', 'value' => 0],
            ['is_deleted', 'default', 'value' => self::IS_DELETED_NO],
            ['status', 'default', 'value' => self::STATUS_DRAFT],
            ['deleted_at', 'default', 'value' => self::DELETED_AT_DEFAULT],
        ];
        $parentRules = parent::rules();

        unset($parentRules[0]);

        return ArrayHelper::merge($rules, $parentRules);
    }

    /**
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

}
