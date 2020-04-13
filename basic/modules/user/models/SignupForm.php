<?php
namespace app\modules\user\models;
use Yii;

use app\modules\user\models\User;
use app\modules\user\models\Users;
use yii\base\Model;


class SignupForm extends Model{

	public $displayname;
	public $email;
	public $username;
	public $password;

 
	public function rules()
  {
      return [
          
          [['displayname', 'email', 'username', 'password'], 'required'],

          ['email', 'email'],
          ['email', 'unique', 'targetClass' => 'app\modules\user\models\User', 'targetAttribute' => 'email' ,'message' => 'This email has already been taken.'],

          ['username', 'match', 'pattern' => '/^[A-Za-z0-9]+$/', 'message' => 'Логин должен содержать только латинские буквы и цифры'],
          ['username', 'string'],

          ['password', 'string', 'min' => 6],
          ['password', 'match', 'pattern' => '/^\S*[0-9]+\S*[0-9]+\S*$/', 'message' => 'Пароль должен содержать минимум 2 цифры.'],
          ['password', 'match', 'pattern' => '/^\S*[a-zA-Z]+\S*[a-zA-Z]+\S*$/', 'message' => 'Пароль должен содержать минимум 2 буквы.'],
          ['password', 'match', 'pattern' => '/^\S*[!"#$%&\'()*+,-.\/:;<=>?@[\]^_`{|}~]+\S*[!"#$%&\'()*+,-.\/:;<=>?@[\]^_`{|}~]+\S*$/', 'message' => 'Пароль должен содержать минимум 2 спец. символа.'],
          
      ];
  }  

  public function signup()
  {
    if($this->validate()){      
      $user = new User();
      $user->attributes = $this->attributes;
      
      $user->hashPassword($user->password);
         
      return $user->create();
    }
  }

  public function sendActivationEmail(){
    $user = User::findOne(
      ['email'=>$this->email]
    );
    if($user){
      if($user->save()){
        return Yii::$app->mailer->compose('activationEmail', ['user'=> $user])
          ->setFrom('bogdan-anastasiya@inbox.ru')
          ->setTo($this->email)
          ->setSubject('Account activation '.Yii::$app->name)
          ->setTextBody('Текст сообщения')          
          ->send();  
      }
    }
    return false;  
  }
  
}
?>