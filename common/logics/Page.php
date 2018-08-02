<?php

namespace common\logics;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\helpers\ArrayHelper;

class Page extends \common\models\Page
{
    const STATUS_DELETED = -1; //状态：删除
    const STATUS_DISABLED = 0; //状态：禁用
    const STATUS_DRAFT = 1; //状态：草稿
    const STATUS_PUBLISHED = 2; //状态：发布

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
                    SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE => 'updated_at',
                ]
            ],
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'status' => self::STATUS_DELETED
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
            ['status', 'default', 'value' => self::STATUS_DRAFT],
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
