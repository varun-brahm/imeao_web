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
                    'width' => '30px',
                ],
                [    'class'=>'kartik\grid\ExpandRowColumn',
                    'expandTitle'=>'Detail Info '  ,
                    'width'=>'50px',
                    'value'=> function ($model) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail'=>function ($model) {
                        return $this->render('student_det', ['id'=>$model->studentID]);
                    },
                    'headerOptions'=>['class'=>'kartik-sheet-style'] ,
                    'expandOneOnly'=>true
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
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign'=>'middle',
                     'template'=>'{klas} {update} {verklaring} {verklaring2} {afschrijving}',
                    'urlCreator' => function($action, $model, $key, $index) {
                        return Url::to(['student-'.$action,'student_id'=>$key]);
                    },
                    'viewOptions'=>['role'=>'modal-remote','title'=>'Bekijken', 'data-toggle'=>'tooltip', 'class'=>'btn btn-secondary btn-xs'],
                    'updateOptions'=>['data-pjax'=>0,'title'=>'Update', 'data-toggle'=>'tooltip', 'class'=>'btn btn-primary btn-xs','target'=>'_blank'],
                    'deleteOptions'=>['role'=>'modal-remote','title'=>'Verwijderen',
                        'class'=>'btn btn-danger btn-xs',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Notificatie',
                        'data-confirm-message'=>'Ben je zeker om deze te verwijderen?'],
                    'buttons' => [
                        'klas' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-school"></span>', ['student-klas-create', 'studentid' => $model->studentID],
                                [
                                    'role'=>'modal-remote',
                                    'title' => 'Klas ',
                                    'class' => 'btn btn-success btn-xs',
                                    'data-toggle'=>'tooltip',

                                ]);
                        },
                        'verklaring' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-file-pdf"></span>', ['student-verklaring', 'studentid' => $model->studentID],
                                [
                                    'data-pjax'=>0,
                                    'target'=>'_blank',
                                    'title' => 'Verklaring ',
                                    'class' => 'btn btn-success btn-xs',
                                    'data-toggle'=>'tooltip',

                                ]);
                        },
                        'verklaring2' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-file-pdf"></span>', ['student-verklaring2', 'studentid' => $model->studentID],
                                [
                                    'data-pjax'=>0,
                                    'target'=>'_blank',
                                    'title' => 'Verklaring ',
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-toggle'=>'tooltip',

                                ]);
                        },
                        'afschrijving' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-file-pdf"></span>', ['student-afschrijving', 'studentid' => $model->studentID],
                                [
                                    'data-pjax'=>0,
                                    'target'=>'_blank',
                                    'title' => 'Afschrijving ',
                                    'class' => 'btn btn-danger btn-xs',
                                    'data-toggle'=>'tooltip',

                                ]);
                        },
                    ],
                ],
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="fas fa-plus"></i>', ['student-create'],
                        ['data-pjax' => 0,'target'=>'_blank', 'title' => 'Nieuwe student', 'class' => 'btn btn-success']).
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
                'after'=>true,
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
