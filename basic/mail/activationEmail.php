<?php
	/**
    * @var $user app\modules\user\models\User
    */

	use yii\helpers\Html;
	use yii\helpers\Url;	
?>

<?= Html::a('Activate account', Url::toRoute(['auth/activate-account','key' => $user->authKey], true)) ?>


