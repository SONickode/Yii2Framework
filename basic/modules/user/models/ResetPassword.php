<?php
namespace app\modules\user\models;
use Yii;
use app\modules\user\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;


class ResetPassword extends Model{	
	public $password;
  private $_user;
  

  public function __construct($key, $config=[]){
    if(empty($key)||!is_string($key)){
      throw new InvalidParamException("The key value must not be empty!");      
    }
    
    $this->_user = User::findByResetKey($key);
    
    if(!$this->_user){
      throw new InvalidParamException("Invalid key!");      
    }

    parent::__construct($config);
  }

	public function rules()
  {
      return [          
          [['password'], 'required'],
          ['password', 'string', 'min' => 6],
          ['password', 'match', 'pattern' => '/^\S*[0-9]+\S*[0-9]+\S*$/', 'message' => 'Пароль должен содержать минимум 2 цифры.'],
          ['password', 'match', 'pattern' => '/^\S*[a-zA-Z]+\S*[a-zA-Z]+\S*$/', 'message' => 'Пароль должен содержать минимум 2 буквы.'],
          ['password', 'match', 'pattern' => '/^\S*[!"#$%&\'()*+,-.\/:;<=>?@[\]^_`{|}~]+\S*[!"#$%&\'()*+,-.\/:;<=>?@[\]^_`{|}~]+\S*$/', 'message' => 'Пароль должен содержать минимум 2 спец. символа.'],         
          
      ];
  }

  public function attributeLabels(){
    return [
      'password' => 'Enter new password'
    ];
  }

  public function resetPassword(){
    /* @var $user User */
    $user = $this->_user;
    $user->password = $user->hashPassword($this->password);
    $user->removeResetKey();
    return $user->save();   
  }

}
?>