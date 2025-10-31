<?php

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use hoaaah\ajaxcrud\CrudAsset;
use hoaaah\ajaxcrud\BulkButtonWidget;

$dataProvider = new ActiveDataProvider([
    'query' => \app\models\Schooljaar::find()->where(['IDstudent'=>$id]),
    'pagination' => [
        'pageSize' => 1000,
    ],
]);

CrudAsset::register($this);
?>
<div class="melding-det-index">
    <?= GridView::widget([
        'id'=>'crud-datatable-det'.$id,
        'dataProvider' => $dataProvider,
        'pjax'=>true,
        'columns'=>[
            [
                'class' => 'kartik\grid\SerialColumn',
                'width' => '30px',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'huidige_klas',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'vorige_Klas',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'schooljaar',
                'value'=>'jaar.naam',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'datum_inschrijving_her',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'opmerking',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'vAlign'=>'middle',
                'template'=>'{update} {delete}',
                'urlCreator' => function($action, $model, $key, $index) {
                    return Url::to(['student-klas-'.$action,'schooljaarid'=>$key]);
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
        'bordered' => false,
        'striped' => false,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'panel' => [
            'type' =>false,
            'heading' => false,
            'before'=> false,
            'after'=> false,
        ]
    ]) ?>
</div>