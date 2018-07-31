<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property string $slug 别名
 * @property string $title 标题
 * @property string $body 内容
 * @property int $view 浏览
 * @property int $status 状态，-1：删除；0：禁用；1：启用
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'body'], 'required'],
            [['body'], 'string'],
            [['view', 'status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('model/page', 'ID'),
            'slug' => Yii::t('model/page', 'Slug'),
            'title' => Yii::t('model/page', 'Title'),
            'body' => Yii::t('model/page', 'Body'),
            'view' => Yii::t('model/page', 'View'),
            'status' => Yii::t('model/page', 'Status'),
            'created_at' => Yii::t('model/page', 'Created At'),
            'updated_at' => Yii::t('model/page', 'Updated At'),
        ];
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
