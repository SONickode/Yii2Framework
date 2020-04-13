<?php
namespace app\modules\user\models;
use Yii;
use app\modules\user\models\User;
use yii\base\Model;

class RetrievePasswordForm extends Model{	
	public $email;
	
	public function rules()
  {
      return [
        ['email', 'required'],
        ['email', 'filter', 'filter' => 'trim'],
        ['email', 'email'],
        ['email', 'exist', "targetClass" => 'app\modules\user\models\User', 'targetAttribute' => 'email', 'message' => 'This email is not registered']          
      ];
  }

  public function attributeLabels(){
    return [
      'email' => 'Email to retrieve password'
    ];
  }

  public function sendEmail(){
    $user = User::findOne(
      ['email'=>$this->email]
    );

    if($user){
      $user->generateResetKey();
      if($user->save()){
        return Yii::$app->mailer->compose('resetPassword', ['user'=> $user])
          ->setFrom('bogdan-anastasiya@inbox.ru')
          ->setTo($this->email)
          ->setSubject('Reset Password for'.Yii::$app->name)
          ->setTextBody('Текст сообщения')          
          ->send();
      }
    }
    return false;
  }
  
}
?>