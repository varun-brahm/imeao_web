<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]);
?>

<?= $form->field($model, 'rawData')->textarea([
    'rows' => 15,
    'placeholder' => "Plak hier je Excel-gegevens (tab gescheiden)\nNaam\tVoornaam\tM3T1\tM3T2\n..."
]) ?>


<?php ActiveForm::end(); ?>
