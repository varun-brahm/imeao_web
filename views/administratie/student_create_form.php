<?php

use app\models\artikel;
use kartik\widgets\Select2;
use kartik\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;
use hoaaah\ajaxcrud\CrudAsset;

CrudAsset::register($this);

?>
<?php $form = ActiveForm::begin([
    'id' => 'studenten_form',
    'options' => [
//            'enctype' => 'multipart/form-data',
//            'target' => '_self'
    ]
]); ?>
<style>    .select2-container .select2-selection--single .select2-selection__rendered {
        display: block;
        padding-left: 8px;
        padding-right: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: wrap;
    }
    .select2-container--krajee-bs4 .select2-selection--single,
    .select2-container--krajee-bs4 .select2-selection--multiple {
        cursor: default;
        overflow: hidden;
    }

    }</style>
<?= $form->field($model, 'student')->label('Studenten Toevoegen')->widget(MultipleInput::className(), [
    'id'               => 'student',
    'max'              => 10,
    'min'              => 1,
    'allowEmptyList'   => true,
    'addButtonOptions' => [
        'class' => 'btn btn-success',
        'label' => '<span class="fas fa-plus"></span>',
    ],
    'removeButtonOptions' => [
        'class' => 'btn btn-danger',
        'label' => '<span class="fas fa-times"></span>',
    ],
    'rowOptions' => [
        'style' => 'border:none',
    ],
    'columns' => [
//        [
//            'name' => 'artikelid',
//            'type' => Select2::className(),
//            'columnOptions' => [
//                'class' => 'col-6 mw-50',
//            ],
//            'options' => [
//                'size' => Select2::MEDIUM,
//                'data' => ArrayHelper::map(Artikel::find()->orderBy('artikel_code')->all(),'artikelid', function ($artikel) {
//                    return $artikel->artikel_code  . ' (' . $artikel->omschrijving . ')';
//
//
//                }),
//                'options' => [
//                    'class' => 'form-control',
//                ],
//                'pluginOptions' => [
//                    'placeholder' => 'Wetsartikelen',
//                ],
//
//            ],
//            'title' => 'Artikel', // Set the label for this column
//        ],
        [
            'name' => 'no',
            'type' => 'textinput',
            'columnOptions' => [
                'class' => 'col-1 mw-50',
            ],
            'options' => [
                'type' => 'number',
                'min'  => 0,
                'class'=> 'form-control'
            ],
            'title' => 'no', // Set the label for this column
        ],
        [
            'name' => 'naam',
            'type' => 'textarea',
            'columnOptions' => [
                'class' => 'col-4 mw-50',
            ],
            'options' => [
                'placeholder' => 'naam',
            ],
            'title' => 'naam', // Set the label for this column
        ],
        [
            'name' => 'voornaam',
            'type' => 'textarea',
            'columnOptions' => [
                'class' => 'col-4 mw-50',
            ],
            'options' => [
                'placeholder' => 'Voornaam',
            ],
            'title' => 'voornaam', // Set the label for this column
        ],
        [
            'name' => 'opmerking',
            'type' => 'textarea',
            'columnOptions' => [
                'class' => 'col-2 mw-30',
            ],
            'options' => [
                'placeholder' => 'Opmerking',
            ],
            'title' => 'opmerking', // Set the label for this column
        ],
        [
            'name' => 'klas',
            'type' => 'checkbox',
            'columnOptions' => [
                'class' => 'col-1 mw-10',
            ],
            'title' => '1 klas', // Set the label for this column
        ],
    ],
])->label(false); ?>

<?php  ActiveForm::end(); ?>
