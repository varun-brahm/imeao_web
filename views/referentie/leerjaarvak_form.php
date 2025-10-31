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
                <?= $form->field($model, 'vak_id')->label('Vak')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\app\models\Vak::find()
                        ->where('vak_id > 0')
                        ->orderBy('vak')->all(),'vak_id', 'vak'),
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,

                    ],
                ]) ?>
        </div>
        <div class="row">
                <?= $form->field($model, 'leerjaar_id')->label('Leerjaar')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\app\models\Leerjaar::find()
                        ->where('leerjaar_id > 0')
                        ->orderBy('naam')->all(),'leerjaar_id', 'naam'),
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,

                    ],
                ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
