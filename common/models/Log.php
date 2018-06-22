<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property int $id
 * @property int $level
 * @property string $category
 * @property double $log_time
 * @property string $prefix
 * @property string $message
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level'], 'integer'],
            [['log_time'], 'number'],
            [['prefix', 'message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('model/log', 'ID'),
            'level' => Yii::t('model/log', 'Level'),
            'category' => Yii::t('model/log', 'Category'),
            'log_time' => Yii::t('model/log', 'Log Time'),
            'prefix' => Yii::t('model/log', 'Prefix'),
            'message' => Yii::t('model/log', 'Message'),
        ];
    }
}
