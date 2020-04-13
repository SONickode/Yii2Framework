<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => $labelName]); ?>

    <?= $form->field($model, 'username', ['inputOptions' => ['id' => "$labelName-username", 'class' => 'form-control']])->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'email', ['inputOptions' => ['id' => "$labelName-email", 'class' => 'form-control']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'displayname', ['inputOptions' => ['id' => "$labelName-displayname", 'class' => 'form-control']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password', ['inputOptions' => ['id' => "$labelName-password", 'class' => 'form-control']])->passwordInput(['maxlength' => true]) ?>
    <?php if($labelName === 'update'){
        ?>
    <?= $form->field($model, 'privileges')->checkbox(['label' => 'Admin Privileges', 'checked' => Yii::$app->authManager->checkAccess($model->id, 'admin'), 'value' => 'admin' ])  ?>
   
   
    <?php }?>
    
   
   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
