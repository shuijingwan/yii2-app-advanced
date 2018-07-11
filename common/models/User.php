<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status 状态，-1：删除；0：禁用；1：启用
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('model/user', 'ID'),
            'username' => Yii::t('model/user', 'Username'),
            'auth_key' => Yii::t('model/user', 'Auth Key'),
            'password_hash' => Yii::t('model/user', 'Password Hash'),
            'password_reset_token' => Yii::t('model/user', 'Password Reset Token'),
            'email' => Yii::t('model/user', 'Email'),
            'status' => Yii::t('model/user', 'Status'),
            'created_at' => Yii::t('model/user', 'Created At'),
            'updated_at' => Yii::t('model/user', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
