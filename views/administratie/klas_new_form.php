<?php

use app\models\UsersType;
use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
$docent_naam = UsersType::find()->where(['name' => 'Leerkracht'])->one();
?>

<div class="school-create-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row row-cols-2">
        <div class="col">
            <?= $form->field($model, 'schooljaar_id')->label('jaar')->widget(Select2::classname(), [
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
            <?= $form->field($model, 'leerjaar_id')->label('leerjaar')->widget(Select2::classname(), [
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
    <div class="row row-cols-1">
        <div class="col">

            <?= $form->field($model, 'Klas')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>

</div>
