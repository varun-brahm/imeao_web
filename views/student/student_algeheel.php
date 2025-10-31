<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $klas app\models\Schooljaar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Studenten in klas: " . Html::encode($klas->huidige_klas);
$this->params['breadcrumbs'][] = $this->title;
\yii\helpers\Html::csrfMetaTags();
$columns = [
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
    'student.email_adres',
    'student.opmerking',
    'huidige_klas',
    'vorige_Klas',
    'opmerking'
];

// Convert strings to GridView column format for filtering and formatting
$gridColumns = array_map(function($col) {
    return [
        'attribute' => $col,
        'filterInputOptions' => ['class' => 'form-control', 'autocomplete' => 'off'],
        'headerOptions' => ['style' => 'min-width: 120px; white-space: nowrap;'],
    ];
}, $columns);

?>

<div class="student-algeheel">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,  // You can add a StudentSearch model here if you want filtering
        'columns' => $gridColumns,
        'striped' => true,
        'hover' => true,
        'bordered' => true,
        'responsive' => true,
        'pjax' => true,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Studenten Lijst',
        ],
    ]) ?>
</div>
<?= \yii\helpers\Html::csrfMetaTags() ?>
<?php Modal::begin([
    "options"=>[
        'tabindex' => false
    ],
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
    "size"=>"modal-lg",
])?>
<?php Modal::end(); ?>