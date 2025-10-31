<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$this->title = 'Two-Factor Authentication';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-2fa-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please enter the two-factor authentication code from your authenticator app:</p>

    <?php $form = ActiveForm::begin(['id' => '2fa-login-form']); ?>

    <b>New Password</b><?= Html::input('text','twoFactorCode','', $options=['class'=>'form-control', 'maxlength'=>10, 'style'=>'width:350px']) ?>Passwords may only use characters A-Z a-z 0-9

<!--    --><?php //= $form->field($model, 'twoFactorCode')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
