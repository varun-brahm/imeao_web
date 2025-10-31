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
<div class="cijfer-index">
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
                    'attribute'=>'cijfer_id',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'docent_id',
                    'value'=>'docent.naam',
                    'label'=>'Docent',
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>[
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Docent::find()->orderBy('naam')->all(),
                            'docent_id', 'naam'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'vak_id',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'student_id',

                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'klas_id',
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign'=>'middle',
                    // 'template'=>'{view} {update} {delete}',
                    'urlCreator' => function($action, $model, $key, $index) {
                        return Url::to(['cijfer-'.$action,'cijferid'=>$key]);
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
                    Html::a('<i class="fas fa-plus"></i>', ['cijfer-create'],
                        ['role' => 'modal-remote', 'title' => 'Nieuwe cijfer', 'class' => 'btn btn-success']).
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
