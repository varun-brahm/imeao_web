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
<div class="school-index">
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
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'Klas',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'leerjaar_id',
                    'value'=>'leerjaar.naam',
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>[
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Leerjaar::find()->orderBy('naam')->all(),
                            'leerjaar_id', 'naam'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'schooljaar_id',
                    'value'=>'schooljaar.naam',
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>[
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Jaar::find()->orderBy('naam')->all(),
                            'jaar_id', 'naam'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign'=>'middle',
                    'template'=>'{view} {edit_klas} {print-rapport}',
                    'urlCreator' => function($action, $model, $key, $index) {
                        return Url::to(['moederlijst-'.$action,'klas_id'=>$key]);
                    },
                    'viewOptions'=>['data-pjax'=>0,'title'=>'Bekijken', 'data-toggle'=>'tooltip', 'class'=>'btn btn-secondary btn-xs', 'target'=>'_blank'],
                    'updateOptions'=>['data-pjax'=>0,'title'=>'Update', 'data-toggle'=>'tooltip', 'class'=>'btn btn-primary btn-xs fa-solid fa-user-graduate', 'target'=>'_blank'],
                    'deleteOptions'=>['role'=>'modal-remote','title'=>'Verwijderen',
                        'class'=>'btn btn-danger btn-xs',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Notificatie',
                        'data-confirm-message'=>'Ben je zeker om deze te verwijderen?'],

                    'buttons' => [
                        'print-rapport' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-book"></span>', ['print-alle-rapport', 'klas_id' => $model->klas_id],
                                [
                                    'data-pjax'=>0,
                                    'target'=>'_blank',
                                    'title' => 'Print alle rapport ',
                                    'class' => 'btn btn-success btn-xs',
                                    'data-toggle'=>'tooltip',

                                ]);
                        },
                        'update_school' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-solid fa-9">10</span>', ['school-update', 'schoolid' => $model->klas_id],
                                [
                                    'data-pjax'=>0,
                                    'title' => 'Cijfers ',
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-toggle'=>'tooltip',
                                    'target'=>'_blank'
                                ]);
                        },
                        'studenten_add' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-user-graduate"></span>', ['student-create', 'id' => $model->klas_id],
                                [
                                    'role'=>'modal-remote',
                                    'title' => 'Studenten ',
                                    'class' => 'btn btn-warning btn-xs',
                                    'data-toggle'=>'tooltip',

                                ]);
                        },
//                        'transfer' => function ($url, $model, $key) {
//                            return Html::a('<span class="fa fa-light fa-retweet"></span>', ['transfer', 'keyid' => $model->keyid],
//                                [
//                                    'role'=>'modal-remote',
//                                    'title' => 'Transfer',
//                                    'class' => 'btn btn-primary btn-xs',
//                                    'data-toggle'=>'tooltip'
//                                ]);
//                        },
                    ],
                ],
            ],
            'toolbar'=> [
                ['content'=>
//                    Html::a('<i class="fas fa-plus"></i>', ['klas-create'],
//                        ['role' => 'modal-remote', 'title' => 'Nieuwe klas', 'class' => 'btn btn-success']).
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
