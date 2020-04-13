<?php

namespace app\modules\user\models;

use Yii;
use yii\web\IdentityInterface;
use yii\commands\Rbac;
use yii\modules\user\models\Users;


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
            [['username', 'email', 'password'], 'required'],
            [['username', 'email', 'displayname', 'resetKey'], 'string', 'max' => 64],
            //['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
            ['username', 'match', 'pattern' => '/^[A-Za-z0-9]+$/'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\modules\user\models\User', 'targetAttribute' => 'email' ,'message' => 'This email has already been taken.'],

            ['password', 'string', 'min' => 6],
            ['password', 'match', 'pattern' => '/^\S*[0-9]+\S*[0-9]+\S*$/'],
            ['password', 'match', 'pattern' => '/^\S*[a-zA-Z]+\S*[a-zA-Z]+\S*$/'],
            ['password', 'match', 'pattern' => '/^\S*[!"#$%&\'()*+,-.\/:;<=>?@[\]^_`{|}~]+\S*[!"#$%&\'()*+,-.\/:;<=>?@[\]^_`{|}~]+\S*$/'],
                     
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
            'email' => 'Email',
            'displayname' => 'Displayname',
            'password' => 'Password',
            'resetKey' => 'Reset Key',            
            'authKey' => 'Auth Key',
            'privileges' => 'Privileges',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);

    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        // return null;
        // return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['username'], $username) === 0) {
        //         return new static($user);
        //     }
        // }
        return User::find()->where(['username'=>$username])->one();
        return null;
    }

    public static function findByResetKey($key)
    {
       
        return static::findOne(['resetKey' => $key]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    


    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }   

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    public static function findByAuthKey($key)
    {       
        return static::findOne(['authKey' => $key]);
    }

    public function removeAuthKey(){
        return $this->authKey = '0';
    }

     public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateAuthKey();
                $this->generateResetKey();       
                               
            }
            
            return true;
        }
        return false;
    }

    function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $user_profile = new \app\modules\user\models\Users;
            $user_profile->id = $this->id;
            $user_profile->username = $this->username;
            $user_profile->email =  $this->email;
            $user_profile->displayname = $this->displayname;
            $user_profile->password = $this->password;
            $user_profile->resetKey = $this->resetKey;
            $user_profile->save();
        } else {
            \app\modules\user\models\Users::updateAll(['username' => $this->username,
                'email'=>$this->email,
                'displayname'=>$this->displayname,
                'password' => $this->password,
                'resetKey' => $this->resetKey], "id = $this->id"); 
        }
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        
        if (Yii::$app->getSecurity()->validatePassword($password, $this->password))
        return true;
    }

    public function hashPassword($password)
    {
        return $this->password = Yii::$app->security->generatePasswordHash($password);;
    }    


    public function resetKey()
    {
        return $this->resetKey;
    }

    public function removeResetKey(){
        return $this->resetKey = '0';
    }
    public function generateResetKey()
    {
        $this->resetKey = Yii::$app->security->generateRandomString();
    }
      

    public function create(){
        return $this->save();
    }


}


