<?php

global $voldoende;
global $graduate;
global $rowEligible;

use app\models\Leerjaar;
use app\models\School;
use app\models\Studentcijfer;
use app\models\Vak;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// Fields to show
$fields = [
    'm1t1', 'm1t2','her1', 'm2t1', 'm2t2','her2', 'm3t1', 'm3t2','her3',
    'm1h1', 'm1h2', 'm1h3', 'm1h4',
    'm2h1', 'm2h2', 'm2h3', 'm2h4',
    'm3h1', 'm3h2', 'm3h3', 'm3h4'
];

$graduate = true;
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
        .geslaagd{
            color: Green;
        }
        .ngeslaagd{
            color: Red;
        }
    </style>

    <?php $form = ActiveForm::begin([
        'id' => 'student_update_form',
    ]); ?>

    <div class="row">
        <?php
        if ($student) {
            // Student basic info
            ?>
            <div class="row row-cols-2 mb-3">
                <h6>Naam: <?= Html::encode($student->naam) ?></h6>
                <h6>Voornaam: <?= Html::encode($student->voornaam) ?></h6>
            </div>
        <?php } ?>

        <div style="overflow-x: auto; white-space: nowrap; width: 100%;">

            <?php foreach ($klassen as $klas):

                $voldoende = 0;
                ?>

                <h4><?= Html::encode($klas->Klas) ?></h4>
                <table class="table">
                    <thead>
                    <tr class="red">
                        <th>Vak</th>
                        <th>Status</th>
                        <?php foreach ($fields as $field): ?>
                            <th><?= Html::encode($field) ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $vakken = School::find()->where(['Klas' => $klas->Klas])->all();

                    foreach ($vakken as $vak) {
                        $passingCount = 0;
                        $except = false;
                        $vakNaam = '';
                        if (!empty($vak->vak_id)) {
                            $vakModel = Vak::findOne($vak->vak_id);
                            $vakNaam = $vakModel ? $vakModel->vak : '';
                        }

                        // Find existing cijfer row for this klas and student
                        $cijfer = StudentCijfer::find()
                            ->where([
                                'klas_id' => $vak->klas_id,
                                'naam' => $student->naam,
                                'voornaam' => $student->voornaam,
                            ])
                            ->one();

                        if (!$cijfer) {
                            continue;
                        }

                        // Determine passingCount first (count only after values are processed)
                        foreach ($fields as $field) {
                            $value = $cijfer->$field;
                            if ($value === 'V' || (is_numeric($value) && $value >= 5.5)) {
                                $passingCount++;
                            }
                        }

                        // Exceptions
                        if ($vak->vak_id == 5 && $passingCount == 1) {
                            $except = true;
                        } else if ($vak->vak_id == 21 && $passingCount == 1) {
                            $except = true;
                        } else if ($vak->vak_id == 17 && $passingCount == 1) {
                            $except = true;
                        }

                        // Decide status color
                        $cellColor = '';
                        if ($vak->leerjaar_id > 1) {
                            if ($passingCount >= 2 || $except) {
                                $cellColor = "#d4edda"; // green
                            } else {
                                $cellColor = "indianred";
                                $graduate = false;
                            }
                        } else {
                            if ($passingCount >= 3 || $except) {
                                $cellColor = "#d4edda";
                            } else {
                                $cellColor = "indianred";
                                $graduate = false;
                            }
                        }

                        // Output row
                        echo "<tr>";
                        echo "<td>" . Html::encode($vakNaam) . "</td>";
                        echo "<td style='background-color: {$cellColor};'></td>";

                        // Now output all fields
                        foreach ($fields as $field) {
                            $value = $cijfer->$field;
                            $color = 'black';

                            if ($value === 'V' || (is_numeric($value) && $value >= 5.5)) {
                                $color = 'green';
                                $voldoende++;
                            } elseif (
                                ($value !== null && $value !== '' && $value !== 'V') &&
                                ((is_numeric($value) && $value > 0 && $value < 5.5) || $value === 'ND')
                            ) {
                                $color = 'red';
                            }

                            echo "<td>";
                            echo Html::textInput(
                                "StudentCijfer[{$cijfer->student_id}][$field]",
                                $value,
                                [
                                    'class' => 'form-control',
                                    'style' => "color: $color;",
                                    'maxlength' => 4,
                                ]
                            );
                            echo "</td>";
                        }

                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
                <h4>Voldoende: <?= $voldoende?></h4>
            <?php
            endforeach;
            ?>

        </div>
    </div>
    <?php if($graduate == true){?>
        <h1 class="geslaagd">Geslaagd</h1>
    <?php }else{ ?>
        <h1 class="ngeslaagd">Niet geslaagd</h1>
    <?php }?>
    <?= Html::hiddenInput('studentid', $studentid) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Opslaan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Modal::begin([
    "options" => ['tabindex' => false],
    "id" => "ajaxCrudModal",
    "footer" => "",
    "size" => "modal-lg",
]) ?>
<?php Modal::end(); ?>
