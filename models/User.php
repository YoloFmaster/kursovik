<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "User".
 *
 * @property int $id
 * @property string $username
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property string $token
 * @property int $isAdmin
 *
 * @property ShoppingCart[] $shoppingCarts
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'phone', 'email', 'password'], 'required'],
            [['isAdmin'], 'integer'],
            ['email', 'email'],
            [['username', 'phone', 'email', 'password', 'token'], 'string', 'max' => 255],
            [['phone', 'email'], 'unique', 'targetAttribute' => ['phone', 'email']],
            ['username','match' ,'pattern' => '/^[а-яё\s\-]+$/iu', 'message' => 'Имя должно быть на киррилице'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'phone' => 'Phone',
            'email' => 'Email',
            'password' => 'Password',
            'token' => 'Token',
            'isAdmin' => 'Is Admin',
        ];
    }

    //IdentityInter
    public static function findIdentity($id)
    {

    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
    }
    public function validateAuthKey($authKey)
    {
    }

    public function isAdmin(){
        return $this->isAdmin;
    }

    /**
     * Gets query for [[ShoppingCarts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class, ['user_id' => 'id']);
    }
}
