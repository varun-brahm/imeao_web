<?php

use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<?= $form->field($model, 'file')->fileInput() ?>

<?= $form->field($model, 'no')->label('jaar')->widget(Select2::classname(), [
    'data' => \yii\helpers\ArrayHelper::map(\app\models\Jaar::find()
        ->where('jaar_id > 0')
        ->orderBy('naam')->all(),'jaar_id', 'naam'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true,

    ],
]) ?>
<?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>