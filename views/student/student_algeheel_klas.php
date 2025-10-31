<?php

use app\models\Schooljaar;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use hoaaah\ajaxcrud\CrudAsset;
$klas = \app\models\Schooljaar::findOne($id);

//$dataProvider = new ActiveDataProvider([
//    'query' => \app\models\Student::find()->where(['studentID' => $ids]),
//    'pagination' => [
//        'pageSize' => 1000,
//    ],
//]);
$dataProvider = new ActiveDataProvider([
    'query' => \app\models\Schooljaar::find()->where(['huidige_klas'=>$klas->huidige_klas,'schooljaar'=>$klas->schooljaar]),
    'pagination' => [
        'pageSize' => 1000,
    ],
]);

$query = Schooljaar::find()
    ->joinWith('student')
    ->where([
        'schooljaar.huidige_klas' => $klas->huidige_klas,
        'schooljaar.schooljaar' => $klas->schooljaar,
    ])
    ->orderBy(['student.naam' => SORT_ASC]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 1000,
    ],
]);

$dataProvider->pagination = false;

$attributes = [
    'student.id_nummer',
    'student.naam',
    'student.voornaam',
    'student.geslacht',
    'student.etniciteit',
    'student.geboorte_datum',
    'student.geboorte_plaats',
    'student.nationaliteit',
    'student.beroepsprofiel',
    'student.school_huidig',
    'student.school_vorig',
    'student.district_school_vorig',
    'student.naam_ouders',
    'student.adres_ouders',
    'student.nummer_ouders',
    'student.adres_student',
    'student.woonplaats_student',
    'student.district_woonplaats',
    'student.nummer_student',
    'student.huisarts',
    'student.nummer_huisarts',
    'student.opmerking',
    'student.email_adres',
    'huidige_klas',
    'vorige_Klas',
    'opmerking'
];

//$attributes = [
//    'id_nummer',
//    'naam',
//    'voornaam',
//    'student.geslacht',
//    'student.etniciteit',
//    'student.geboorte_datum',
//    'student.geboorte_plaats',
//    'student.nationaliteit',
//    'student.beroepsprofiel',
//    'student.school_huidig',
//    'student.school_vorig',
//    'student.district_school_vorig',
//    'student.naam_ouders',
//    'student.adres_ouders',
//    'student.nummer_ouders',
//    'student.adres_student',
//    'student.woonplaats_student',
//    'student.district_woonplaats',
//    'student.nummer_student',
//    'student.huisarts',
//    'student.nummer_huisarts',
//    'student.opmerking',
//    'student.email_adres',
//    'schooljaar.huidige_klas',
//    'vorige_Klas',
//    'opmerking'
//];

CrudAsset::register($this);

$columns = array_merge(
    [
        [
            'class' => 'kartik\grid\SerialColumn',
            'width' => '30px',
        ],
    ],
    array_map(fn($attr) => [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => $attr,
    ], $attributes)
);
?>

<div class="algemeen-det-index">
<!--    --><?php //= ExportMenu::widget([
//        'dataProvider' => $dataProvider,
//        'columns' => $columns,
//        'target' => ExportMenu::TARGET_BLANK,
//        'fontAwesome' => true,
//        'showConfirmAlert' => false,
//        'exportRequestParam' => 'export',
//        'exportConfig' => [
//            ExportMenu::FORMAT_HTML => false,
//            ExportMenu::FORMAT_TEXT => false,
//            ExportMenu::FORMAT_PDF => [
//                'pdfConfig' => [
//                    'orientation' => \kartik\mpdf\Pdf::ORIENT_LANDSCAPE,
//                ],
//            ],
//        ],
//        'exportFormOptions' => [
//            'id' => 'export-form-'.$id,
//            'action' => \yii\helpers\Url::to(['/student/export-view', 'id' => $id]),
//        ],
//    ]); ?>




    <?= GridView::widget([
        'id' => 'crud-datatable-det' . $id,
        'dataProvider' => $dataProvider,
        'pjax' => false,
        'columns' => $columns,

        'bordered' => false,
        'striped' => false,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'panel' => [
            'type' => false,
            'heading' => false,
            'before' => false,
            'after' => false,
        ],
    ]); ?>

</div>
