<?php
	/**
    * @var $user app\modules\user\models\User
    */

	use yii\helpers\Html;
	use yii\helpers\Url;	

	echo "Hello, ".Html::encode($user->username).'! ';
	echo Html::a('To change the password follow this link', Url::toRoute(['auth/reset_password','key' => $user->resetKey], true));


?>