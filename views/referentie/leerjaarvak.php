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
<div class="recht-index">
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
                    'attribute'=>'vak_id',
                    'value'=>'vak.vak',
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>[
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Vak::find()->orderBy('vak')->all(),
                            'vak_id', 'vak'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign'=>'middle',
                    'template'=>'{update}',
                    'urlCreator' => function($action, $model, $key, $index) {
                        return Url::to(['leerjaarvak-'.$action,'leerjaarvak_id'=>$key]);
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
                ],
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="fas fa-plus"></i>', ['leerjaarvak-create'],
                        ['role' => 'modal-remote', 'title' => 'Nieuwe Leerjaarvak', 'class' => 'btn btn-success']).
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
