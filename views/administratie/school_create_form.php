<?php

use app\models\UsersType;
use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

?>

<?php
$docent_naam = UsersType::find()->where(['name' => 'Leerkracht'])->one();
$user_type = Yii::$app->user->identity->functie;
 ?>
<div class="school-create-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row row-cols-2">
        <div class="col">
            <?= $form->field($model, 'schooljaar')->label('jaar')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Jaar::find()
                    ->where('jaar_id > 0')
                    ->orderBy('naam')->all(),'jaar_id', 'naam'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true,

                ],
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'leerjaar')->label('leerjaar')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Leerjaar::find()
                    ->where('leerjaar_id > 0')
                    ->orderBy('naam')->all(),'leerjaar_id', 'naam'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true,

                ],
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'vak')->label('Vak')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Vak::find()
                    ->where('vak_id > 0')
                    ->orderBy('vak')->all(),'vak_id', 'vak'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true,

                ],
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'Vakdocent')->label('Vakdocent')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\users::find()
                    ->where('id > 0')->andWhere(['users_type_id'=> $docent_naam->id])
                    ->orderBy('name')->all(),'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true,

                ],
            ]) ?>
        </div>
    </div>
    <div class="row row-cols-2">
        <div class="col">

            <?= $form->field($model, 'Klas')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'mentor')->label('Mentor')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\users::find()
                    ->where('id > 0')->andWhere(['users_type_id'=> $docent_naam->id])
                    ->orderBy('name')->all(),'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true,

                ],
            ]) ?>
        </div>
    </div>


    </div>
    <?php ActiveForm::end(); ?>

</div>
