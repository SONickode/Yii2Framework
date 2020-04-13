<?php
namespace app\modules\user\models;
use Yii;
use app\modules\user\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;


class ActivateAccount extends Model{
  	
  private $_user;
	
  public function __construct($key, $config=[]){
    if(empty($key)||!is_string($key)){
      throw new InvalidParamException("The key value must not be empty!");      
    }

    $this->_user = User::findByAuthKey($key);
    
    if(!$this->_user){
      throw new InvalidParamException("Invalid key!");      
    }

    parent::__construct($config);
  }

	
  public function activateAccount(){
    /* @var $user app\modules\user\models\User */
    $user = $this->_user;
   
    $user->privileges = 'active';
    
    $auth = Yii::$app->authManager;
    $active = $auth->getRole('active');
    $auth->assign($active, $user->getId());

    $user->removeAuthKey();
    return $user->save();   
  }

}
?>