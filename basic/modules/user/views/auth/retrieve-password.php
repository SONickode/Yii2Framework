<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\user\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Retrieve Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-retrieve-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please enter email address to retrieve your password: </p>

    <?php $form = ActiveForm::begin([
        'id' => 'restore',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
       
        <?= $form->field($model, 'email')->input('email', ['id' => 'restore-email']) ?>        

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Restore password', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    
</div>