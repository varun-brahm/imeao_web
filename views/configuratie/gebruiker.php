<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use hoaaah\ajaxcrud\CrudAsset;
use hoaaah\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);
?>
<div class="gebruiker-index">
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
                    'attribute'=>'username',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'name',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'email',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'users_type_id',
                    'value'=>'userType.name',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'active',
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign'=>'middle',
                     'template'=>'{qr_code} {update} {delete}',
                    'urlCreator' => function($action, $model, $key, $index) {
                        return Url::to(['gebruiker-'.$action,'id'=>$key]);
                    },
                    'viewOptions'=>['role'=>'modal-remote','title'=>'Bekijken', 'data-toggle'=>'tooltip', 'class'=>'btn btn-secondary btn-xs'],
                    'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip', 'class'=>'btn btn-primary btn-xs'],
                    'deleteOptions'=>['role'=>'modal-remote','title'=>'Verwijderen',
                        'class'=>'btn btn-danger btn-xs',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Notificatie',
                        'data-confirm-message'=>'Ben je zeker om deze te verwijderen?'],

                    'buttons' => [
                        'qr_code' => function ($url, $model, $key) {
                            return Html::a('<span class="fas fa-qrcode"></span>', ['show-code', 'id' => $model->id],
                                [
                                    'role'=>'modal-remote',
                                    'title' => 'Klas ',
                                    'class' => 'btn btn-success btn-xs',
                                    'data-toggle'=>'tooltip',

                                ]);
                        },
                        ],
                ],
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="fas fa-plus"></i>', ['gebruiker-create'],
                        ['role' => 'modal-remote', 'title' => 'Nieuw Gebruiker', 'class' => 'btn btn-success']).
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
