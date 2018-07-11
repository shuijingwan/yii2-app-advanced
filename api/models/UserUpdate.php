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
        ];
    }
}
