<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]);
?>

<?= $form->field($model, 'naam')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'voornaam')->textInput(['maxlength' => true]) ?>


<?php ActiveForm::end(); ?>
