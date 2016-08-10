<?php

namespace app\models;

use app\components\MyActiveRecord;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $hash_password
 * @property integer $is_active
 */
class User extends MyActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['email'],'email'],
            [['name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 256],
            [['password'], 'string', 'max' => 20, 'min'=>6, 'on'=>'register'],
            [['passwordRepeat'], 'compare', 'compareAttribute'=>'password', 'on'=>'register'],
            [['passwordRepeat','password'], 'required', 'on'=>'register'],
            [['email'], 'unique'],
            [['is_active'],'default', 'value'=>1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'Email',
            'is_active' => 'Активный',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return User::find()->where(['id'=>$id])->one();
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return sha1($this->hash_password . $this->email . 'sfjds9IFJdke323');
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $authKey === $this->getAuthKey();
    }

    private function passwordHash($password){
        return sha1('sosd8383jfsSEW'.$password . 'sjso238sdk');
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->hash_password === $this->passwordHash($password);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        $user = self::find()->where(['email'=>$email])->one();
        return $user;
    }

    private $_password;
    public function setPassword($password){
        $this->hash_password=$this->passwordHash($password);
        $this->_password=$password;
    }

    public function getPassword(){
        return $this->_password;
    }

    private $_passwordRepeat;
    public function getPasswordRepeat(){
        return $this->_passwordRepeat;
    }
    public function setPasswordRepeat($value){
        $this->_passwordRepeat=$value;
    }
}
