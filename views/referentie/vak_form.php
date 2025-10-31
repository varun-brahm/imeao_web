<?php

use app\models\Users;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

?>

<div class="leerjaarvak-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container">
        <div class="row">
            <?= $form->field($model, 'vak')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
