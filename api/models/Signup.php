<?php
namespace api\models;

use yii\base\Model;

/**
 * Signup
 */
class Signup extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
}
