<?php
use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

?>

<div class="gebruiker-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row row-cols-2">
        <div class="col">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row row-cols-1">
        <div class="col">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>  
        <div class="col">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row row-cols-2">
        <div class="col">
            <?= $form->field($model, 'users_type_id')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\UsersType::find()
                    ->where('id > 0')
                    ->orderBy('name')->all(),'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'recht_id')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Recht::find()
                    ->where('recht_id > 0')
                    ->orderBy('naam')->all(),'recht_id', 'naam'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>
        <div class="col" align="center">
            <?= $form->field($model, 'active')->checkbox() ?>
        </div>

    <?php ActiveForm::end(); ?>
    
</div>
