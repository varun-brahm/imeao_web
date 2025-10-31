<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use hoaaah\ajaxcrud\CrudAsset;
use hoaaah\ajaxcrud\BulkButtonWidget;


use yii\helpers\Json;
use yii\web\Response;

CrudAsset::register($this);
?>

<div class="student-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns'=>[
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'width' => '20px',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'naam',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'voornaam',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'klas_id',
                    'value' => 'klas.Klas',
                    'filter' => false, // Disable filter for this column
                    'label'=>'Klas'
                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign'=>'middle',
                    'template'=>'{rapport} {update} ',
                    'urlCreator' => function($action, $model, $key, $index) {
                        return Url::to(['student-'.$action,'studentid'=> $model->student_id]);
                    },
                    'viewOptions'=>['role'=>'modal-remote','title'=>'Bekijken', 'data-toggle'=>'tooltip', 'class'=>'btn btn-secondary btn-xs'],
                    'updateOptions'=>['data-pjax'=>0,'title'=>'Update', 'data-toggle'=>'tooltip', 'class'=>'btn btn-primary btn-xs', 'target'=>'_blank'],
                    'deleteOptions'=>['role'=>'modal-remote','title'=>'Verwijderen',
                        'class'=>'btn btn-danger btn-xs',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Notificatie',
                        'data-confirm-message'=>'Ben je zeker om deze te verwijderen?'],


                    'buttons' => [
                        'rapport' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-file-pdf"></span>', ['student-rapport', 'studentid' => $model->student_id],
                                [
                                    'data-pjax'=>0,
                                    'title' => 'Klas ',
                                    'class' => 'btn btn-success btn-xs',
                                    'data-toggle'=>'tooltip',
                                    'target'=>'_blank'

                                ]);
                        },
                        ],

                ],
            ],
            'toolbar'=> [
                ['content'=>
//                    Html::a('<i class="fas fa-plus"></i>', ['create','form'=>'geloof'],
//                        ['role' => 'modal-remote', 'title' => 'Nieuwe ', 'class' => 'btn btn-success']).
                    Html::a('<i class="fas fa-redo"></i>', [''],
                        ['data-pjax'=>1, 'class'=>'btn btn-primary', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'bordered' => false,
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => false,
                'before'=>'',
                'after'=>false,
            ]
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "options"=>[
        'tabindex' => false
    ],
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
    "size"=>"modal-lg",
])?>
<?php Modal::end(); ?>
