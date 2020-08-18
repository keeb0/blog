<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

class Signup extends Model
{
    public $email;
	public $name;
	public $password;

	public function rules()
	{
		return [
			[['name', 'password', 'email'], 'required'],
            [['email'], 'email'],
            [['name'], 'unique', 'targetClass' => 'app\models\User'],
            [['email'], 'unique', 'targetClass' => 'app\models\User'],
            [['password'], 'string', 'min' => 6],
		];
	}

	public function attributeLabels()
	{
		return [
			'name' => 'Имя пользователя',
            'email' => 'Email',
			'password' => 'Пароль',
		];
	}

    public function signup()
    {
        if ($this->validate()) {
        	$user = new User;
        	if ($this->createUser($user)) {
            	return Yii::$app->user->login($this->getUser());
        	}
        }
        return false;
    }

	public function getUser()
    {
        return User::findOne(['name' => $this->name]);
    }

    public function createUser($user)
    {
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setHashPswd($this->password);

        return $user->save();
    }
}