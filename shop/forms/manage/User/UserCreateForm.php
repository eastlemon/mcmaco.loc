<?php

namespace shop\forms\manage\User;

use Yii;
use shop\entities\User\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $role;

    public function rules(): array
    {
        return [
            [['username', 'email', 'phone', 'role'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email', 'phone'], 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6],
            ['phone', 'integer'],
        ];
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public function attributeLabels(): array
    {
        return [
            'username' => Yii::t('shop', 'Username'),
            'email' => Yii::t('shop', 'Email'),
            'phone' => Yii::t('shop', 'Phone'),
            'role' => Yii::t('shop', 'Role'),
            'password' => Yii::t('shop', 'Password'),
        ];
    }
}