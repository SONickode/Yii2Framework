<?php
namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\LoginForm;
use app\modules\user\models\ResetPassword;
use app\modules\user\models\RetrievePasswordForm;
use app\modules\user\models\SignupForm;
use app\modules\user\models\User;
use app\modules\user\models\ActivateAccount;
use app\modules\user\models\Users;

use yii\filters\AccessControl;

use yii\web\Controller;
use yii\base\InvalidParamException;
use yii\base\BadRequestHttpException;


class AuthController extends Controller 
{   
     
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    } 
   
     public function actionLogin()
    {
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }        
        
        $model = new LoginForm(); 
                      
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            
            $userId = $model->getUser()->id;           
            
            if(Yii::$app->authManager->checkAccess($userId, 'Login') && $model->login()){
                if(Yii::$app->authManager->checkAccess($userId, 'admin')){
                    return $this->redirect(['/admin-panel']);
                }else{
                return $this->goBack();           
                }
            }else {
                Yii::$app->getSession()->setFlash('warning', 'To Log in you need to activate your account (follow the link from the email message!)');
            }    
        }

        
        return $this->render('login', [
            'model' => $model,
        ]);
        
    }
    

    
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    


    public function actionRegister()
    {
        $model = new SignupForm();  
        
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            
            if($model->signup()){
                if($model->sendActivationEmail()){
                    Yii::$app->getSession()->setFlash('warning', 'To activate your account follow the link from the email message!');
                    return $this->goHome();
                }else{
                    Yii::$app->getSession()->setFlash('warning', 'Error!');
                }
            }
        }
        return $this->render('register', ['model'=> $model]);
    }

    public function actionActivateAccount($key){
        $user = new ActivateAccount($key);

        if($user->activateAccount()){
            
            Yii::$app->getSession()->setFlash('warning', 'Your account has been activated successfully!');
        }
        else{
            Yii::$app->getSession()->setFlash('warning', 'Error!');
        }

        return $this->goHome();
    }
    

    public function actionRetrievePassword()
    {
        $model = new RetrievePasswordForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
               if($model->sendEmail()){
                    Yii::$app->getSession()->setFlash('warning', 'Check your email!');
                    return $this->goHome();
               }else{
                    Yii::$app->getSession()->setFlash('warning', 'Error! Unable to reset password!');
               }
            }
        }

        return $this->render('retrieve-password', [
            'model' => $model,
        ]);
    }

    public function actionReset_password($key)
    {
        
        $model = new ResetPassword($key);
        
        if($model->load(Yii::$app->request->post())){
            
            
            if ($model->validate() && $model->resetPassword()) {
                Yii::$app->getSession()->setFlash('warning', 'Password has been changed.');
                return $this->goHome();
            } 
        }

        return $this->render('reset_password', [
            'model' => $model,
        ]);
    }
}
?>