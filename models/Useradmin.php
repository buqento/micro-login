<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_admin".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $created_at
 * @property string $updated_at
 */
class Useradmin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'authKey', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 15],
            [['password'], 'string', 'max' => 100],
            [['authKey'], 'string', 'max' => 64],
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
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getAuthKey(){
        return $this->authKey;
    }

    public function getId(){
        return $this->id;
    }

    public function validateAuthKey($authKey){
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id){
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new \yii\base\NotSupportedException();
    }

    public static function findByUsername($username){
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        return Yii::$app->security->generateRandomString();
    }
    
}
