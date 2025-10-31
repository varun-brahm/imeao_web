<?php

use app\models\Leerjaar;
use app\models\School;
use app\models\Studentcijfer;
use app\models\Vak;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Helper function to render colored input fields based on grade value
 */
function renderGradeInput($model, $attribute)
{
    $value = $model->$attribute;
    $backgroundColor = 'white';
    // Determine background color rules
    if ($value === "V" || (is_numeric($value) && $value >= 5.5)) {
        $textColor = 'black';
    } elseif (($value === "ND") || (is_numeric($value) && $value > 0 && $value < 5.5)) {
        $textColor = 'red';
    } else {

        $textColor = 'black';
    }

    return Html::activeTextInput($model, "[$model->student_id]$attribute", [
        'class' => 'form-control',
        'style' => "background-color: $backgroundColor; color: $textColor;"
    ]);
}

?>

<div class="student-update-form">
    <style>
        table {
            font-family: "Times New Roman", sans-serif;
            border-collapse: collapse;
            width: 100%;
            min-width: 1700px;
            border: 1px solid black;
        }

        td, th {
            border: 1px solid #000000;
            text-align: left;
            padding: 8px;
            background-color: white;
        }

        th {
            background: white;
            position: sticky;
            top: 0;
            box-shadow: 2px 2px 2px 2px darkred;
            border: 1px solid darkred;
        }

        tr.red th {
            background: white;
            color: black;
            border: 1px solid darkred;
        }
        td.formher input.form-control {
            min-width: 80px;  /* adjust as needed */
            width: 100%;
            padding: 4px 6px;
            font-size: 14px;
            text-align: center;
        }
        td.formreg input.form-control {
            min-width: 60px;  /* adjust as needed */
            width: 100%;
            padding: 4px 6px;
            font-size: 14px;
            text-align: center;
        }
    </style>

    <?php $form = ActiveForm::begin([
        'id' => 'student_update_form',
        'action' => ['administratie/save-grades'],
        //'options' => ['enctype' => 'multipart/form-data'], // Uncomment if needed
    ]); ?>

    <div class="row">
        <?php
        $student_det = Studentcijfer::findOne($studentid);
        $klas = School::findOne($student_det->klas_id);
        $klas_naam = Html::encode($klas->Klas);
        $klas_leejaar = Html::encode(Leerjaar::findOne($klas->leerjaar_id)->naam);
        ?>

        <div class="row row-cols-2">
            <h6>Naam: <?= Html::encode($student_det->naam) ?></h6>
            <h6>Voornaam: <?= Html::encode($student_det->voornaam) ?></h6>
            <h6>Klas: <?= $klas_naam ?></h6>
            <h6>Leerjaar: <?= $klas_leejaar ?></h6>
        </div>
    </div>

    <div style="overflow-x: auto; white-space: nowrap; width: 100%;">
        <table class="table">
            <thead>
            <tr class="red">
                <th>Vak</th>
                <th>m1t1</th>
                <th>m1t2</th>
                <th>her1</th>
                <th>m2t1</th>
                <th>m2t2</th>
                <th>her2</th>
                <th>m3t1</th>
                <th>m3t2</th>
                <th>her3</th>
                <th>m1h1</th>
                <th>m1h2</th>
                <th>m1h3</th>
                <th>m1h4</th>
                <th>m2h1</th>
                <th>m2h2</th>
                <th>m2h3</th>
                <th>m2h4</th>
                <th>m3h1</th>
                <th>m3h2</th>
                <th>m3h3</th>
                <th>m3h4</th>
            </tr>
            </thead>
            <tbody>
            <?= Html::hiddenInput('studentid', $student->student_id) ?>

            <?php foreach ($allklas as $klasItem): ?>
                <?php
                $currentKlasId = $klasItem->klas_id;
                $schoolModel = School::findOne($currentKlasId);
                $vak = $schoolModel ? Vak::findOne($schoolModel->vak_id)->vak : 'Onbekend vak';
                $currentKlasCijfers = Studentcijfer::find()
                    ->where(['klas_id' => $currentKlasId])
                    ->andWhere(['naam' => $student->naam])
                    ->andWhere(['voornaam'=> $student->voornaam])
                    ->all();
                ?>

                <?php foreach ($currentKlasCijfers as $cijfer): ?>
                    <tr>
                        <td><?= Html::encode($vak) ?></td>

                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'm1t1') . "</td>" ?>
                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'm1t2') . "</td>" ?>
                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'her1') . "</td>" ?>

                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'm2t1') . "</td>" ?>
                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'm2t2') . "</td>" ?>
                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'her2') . "</td>" ?>

                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'm3t1') . "</td>" ?>
                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'm3t2') . "</td>" ?>
                        <?= "<td class='formreg'>" . renderGradeInput($cijfer, 'her3') . "</td>" ?>

                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm1h1') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm1h2') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm1h3') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm1h4') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm2h1') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm2h2') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm2h3') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm2h4') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm3h1') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm3h2') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm3h3') . "</td>" ?>
                        <?= "<td class='formher'>" . renderGradeInput($cijfer, 'm3h4') . "</td>" ?>
                    </tr>
                <?php endforeach; ?>

            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
Modal::begin([
    "options" => ['tabindex' => false],
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
    "size" => "modal-lg",
]);
Modal::end();
?>
