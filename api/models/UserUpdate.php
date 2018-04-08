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

    const STATUS_DELETED = 0; //状态：已删除
    const STATUS_ACTIVE = 10; //状态：活跃

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
            ['email', 'unique', 'targetClass' => '\api\models\User', 'filter' => ['!=', 'id', $this->id]],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['status'], 'in', 'range' => [self::STATUS_DELETED, self::STATUS_ACTIVE]],
        ];
    }
}
