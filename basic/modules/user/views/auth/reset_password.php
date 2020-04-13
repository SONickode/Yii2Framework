<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\ResetPassword */
/* @var $form ActiveForm */
$this->title = 'Reset Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-reset_password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please enter your new password: </p>

    <?php $form = ActiveForm::begin([
        'id' => 'restore',
       
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
       
        <?= $form->field($model, 'password')->input('password', ['id' => 'restore-newpassword']) ?>        

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Change password', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    
</div>