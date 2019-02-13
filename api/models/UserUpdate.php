<?php
namespace api\models;

use yii\base\Model;

/**
 * UserUpdate
 */
class UserUpdate extends Model
{
    public $id;
    public $email;
    public $password;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\api\models\User', 'filter' => ['and', ['!=', 'id', $this->id], ['is_deleted' => User::IS_DELETED_NO]]],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['status', 'integer'],
        ];
    }
}
