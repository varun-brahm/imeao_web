<?php

use app\models\Student;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::$app->session->getFlash('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>
<div class="student-form">
    <?php $form = ActiveForm::begin(); ?>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-user-graduate"></i> Studentgegevens
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'id_nummer')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'etniciteit')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <?= $form->field($model, 'naam')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'voornaam')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'nummer_student')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'email_adres')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <?= $form->field($model, 'geslacht')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'geboorte_datum')->widget(DatePicker::classname(), [
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'geboorte_plaats')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'nationaliteit')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'school_vorig')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'district_school_vorig')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'school_huidig')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'beroepsprofiel')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-home"></i> Woonplaats van de student
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'adres_student')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'woonplaats_student')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'district_woonplaats')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <i class="fas fa-users"></i> Ouderinformatie
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <?= $form->field($model, 'naam_ouders')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'nummer_ouders')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'adres_ouders')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <i class="fas fa-user-md"></i> Huisarts & Opmerkingen
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <?= $form->field($model, 'huisarts')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'nummer_huisarts')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'opmerking')->textarea(['maxlength' => true, 'rows' => 6]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-right mt-4">
        <?= Html::submitButton('<i class="fas fa-save"></i> Opslaan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
