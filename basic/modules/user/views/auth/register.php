<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'displayname', ['inputOptions' => ['id' => "register-displayname"]])->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'email', ['inputOptions' => ['id' => "register-email"]])->input('email') ?>
        <?= $form->field($model, 'username', ['inputOptions' => ['id' => "register-username"]])->textInput() ?>
        <?= $form->field($model, 'password', ['inputOptions' => ['id' => "register-password"]])->input('password') ?>
        

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>    
</div>
