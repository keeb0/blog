<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

class Login extends Model
{
	public $name;
	public $password;

	public function rules()
	{
		return [
			[['name', 'password'], 'required'],
            [['password'], 'validatePassword'],
		];
	}

	public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

	public function attributeLabels()
	{
		return [
			'name' => 'Имя пользователя',
			'password' => 'Пароль',
		];
	}

    // public function login()
    // {
    //     if ($this->validate()) {
    //         // echo "string";die();
    //         return Yii::$app->user->login($this->getUser());
    //     }
    //     return false;
    // }

	public function getUser()
    {
        return User::findOne(['name' => $this->name]);
    }
}