<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string|null $photo
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Article[] $articles
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password_hash'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'password_hash', 'photo'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'photo' => 'Photo',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['author_id' => 'id']);
    }

    public function validatePassword($password)
    {
        return password_verify($password, $this->password_hash);
    }

    // public function createU($signupForm)
    // {
    //     $this->name = $signupForm->name;
    //     $this->email = $signupForm->email;
    //     $this->setHashPswd($signupForm->password);

    //     return $this->save();
    // }

    public function setHashPswd($password)
    {
        return $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    public function getAuthKey()
    {

    }

    public function validateAuthKey($authKey)
    {

    }
}
