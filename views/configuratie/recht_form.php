<?php

use app\models\Users;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

?>

<div class="recht-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'naam')->textInput(['maxlength' => true]) ?>

    <div class="container">
        <div class="row">
            <h4>Menu </h4>
<!--            <div class="col">-->
<!--                --><?php //= $form->field($model, 'statistieken')->checkBox()->label('Statistieken') ?>
<!--            </div>-->
            <div class="col">
                <?= $form->field($model, 'cijfer')->checkBox()?>
                <?= $form->field($model, 'student_cijfer')->checkBox()?>
                <?= $form->field($model, 'school_cijfer')->checkBox()?>
                <?= $form->field($model, 'moederlijst_cijfer')->checkBox()?>
            </div>
            <div class="col">
                <?= $form->field($model, 'student')->checkBox()?>
                <?= $form->field($model, 'student_student')->checkBox()?>
<!--                --><?php //= $form->field($model, 'school_cijfer')->checkBox()?>
<!--                --><?php //= $form->field($model, 'moederlijst_cijfer')->checkBox()?>
            </div>
<!--            <div class="col">-->
<!--                --><?php //= $form->field($model, 'referentie')->checkBox()?>
<!--                --><?php //= $form->field($model, 'artikelen')->checkBox()?>
<!--                --><?php //= $form->field($model, 'wetboeken')->checkBox()?>
<!--                --><?php //= $form->field($model, 'personen')->checkBox()?>
<!--                --><?php //= $form->field($model, 'ressorten')->checkBox()?>
<!--                --><?php //= $form->field($model, 'district')->checkBox()?>
<!--                --><?php //= $form->field($model, 'regio')->checkBox()?>
<!--                --><?php //= $form->field($model, 'afdelingen')->checkBox()?>
<!--                --><?php //= $form->field($model, 'structuur')->checkBox()?>
<!--                --><?php //= $form->field($model, 'goederen')->checkBox()?>
<!--                --><?php //= $form->field($model, 'rang')->checkBox()?>
<!--                --><?php //= $form->field($model, 'taal')->checkBox()?>
<!--                --><?php //= $form->field($model, 'land')->checkBox()?>
<!--                --><?php //= $form->field($model, 'nationaliteit')->checkBox()?>
<!--                --><?php //= $form->field($model, 'geloof')->checkBox()?>
<!---->
<!---->
<!--            </div>-->
            <div class="col">
                <?= $form->field($model, 'user')->checkBox()?>
                <?= $form->field($model, 'user_user')->checkBox()?>
                <?= $form->field($model, 'user_recht')->checkBox()?>
            </div>
<!--            <div class="col">-->
<!--                --><?php //= $form->field($model, 'portal')->checkBox()?>
<!--                --><?php //= $form->field($model, 'devices')->checkBox()?>
<!--                --><?php //= $form->field($model, 'request')->checkBox()?>
<!--            </div>-->
        </div>
        <div class="row">
            <h4>Alle Rechten</h4>
            <div class="col">
                <?= $form->field($model, 'update_all')->checkBox()?>
<!--                --><?php //= $form->field($model, 'pv_edit')->checkBox()?>
<!--                --><?php //= $form->field($model, 'pv_delete')->checkBox()?>

            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
