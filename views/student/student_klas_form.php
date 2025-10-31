<?php

use app\models\UsersType;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

?>

<?php
$docent_naam = UsersType::find()->where(['name' => 'Docent'])->one();
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
        <?= $form->field($model, 'datum_inschrijving_her')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,

            ]
        ])->label('Datum inschrijving')?>
    </div>
    <div class="row row-cols-2">
        <div class="col">
            <?= $form->field($model, 'huidige_klas')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'vorige_Klas')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row row-cols-1">
        <div class="col">
            <?= $form->field($model, 'opmerking')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

</div>
<?php ActiveForm::end(); ?>

</div>
