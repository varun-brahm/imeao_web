<?php

use app\models\Leerjaar;
use app\models\School;
use app\models\Vak;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="school-form">
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
        td.form input.form-control {
            min-width: 60px;  /* adjust as needed */
            width: 100%;
            padding: 4px 6px;
            font-size: 14px;
            text-align: center;
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

        td.stud {
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 1;
            min-width: 120px;
            border-right: 2px solid #000;
        }

        td.stud + td.stud {
            left: 120px;
            z-index: 1;
        }

        th.stud {
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 2;
            min-width: 120px;
            border-right: 2px solid #000;
        }

        th.stud + th.stud {
            left: 120px;
            z-index: 2;
        }

        tr:hover {
            background-color: #ffff99 !important;
        }
    </style>

    <?php $form = ActiveForm::begin(['id' => 'school_form']); ?>
    <button type="button" id="exportBtn">Export Table to Excel</button>

    <div class="row">
        <?php
        if ($models != null) {
            $klas = School::findOne($models[0]['klas_id']);
            $klas_naam = $klas->Klas;
            $klas_leerjaar_id = $klas->leerjaar_id;
            $klas_leejaar = Leerjaar::findOne($klas_leerjaar_id)->naam;
            $klas_vak_id = $klas->vak_id;
            $klas_vak = Vak::findOne($klas_vak_id)->vak;
        } else {
            $message = "Voeg eerst een student toe in deze klas.";
            echo "
            <script>
                alert('$message');
                window.location.href = 'error';
            </script>";
            exit;
        }
        ?>
        <div class="row row-cols-3">
            <h6 id="filename">Klas: <?= Html::encode($klas_naam) ?></h6>
            <h6>Leerjaar: <?= Html::encode($klas_leejaar) ?></h6>
            <h6>Vak: <?= Html::encode($klas_vak) ?></h6>
        </div>
    </div>

    <div style="overflow-x: auto; white-space: nowrap; width: 100%;">
        <table id="myTable" class="table">
            <thead>
            <tr>
                <th class="hideOnExport"></th>
                <th class="hideOnExport"></th>

                <th colspan="10"><?= Html::encode($klas_naam) ?></th>
                <th colspan="9"><?= Html::encode($klas_vak) ?></th>
            </tr>
            <tr class="red">
                <th class="hideOnExport"></th>
                <th class="hideOnExport"></th>
                <th class="hideOnExport"></th>

                <th class="stud">no</th>
                <th class="stud">Naam</th>
                <th class="stud">Voornaam</th>
                <?php
                $fields = [
                    'opmerking','m1t1', 'm1t2','her1', 'm2t1', 'm2t2','her2', 'm3t1', 'm3t2','her3',
                    'm1h1', 'm1h2', 'm1h3', 'm1h4',
                    'm2h1', 'm2h2', 'm2h3', 'm2h4',
                    'm3h1', 'm3h2', 'm3h3', 'm3h4'
                ];
                foreach ($fields as $f) {
                    echo "<th>{$f}</th>";
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($models as $model): ?>
                <tr>
                    <td class="hideOnExport">
                        <?= Html::a(
                            '<span class="fas fa-file-pdf"></span>',
                            ['administratie/student-rapport', 'studentid' => $model['student_id']],
                            ['class' => 'btn btn-primary', 'target' => '_blank']
                        ) ?>
                    </td>
                    <td class="hideOnExport">
                        <?= Html::a(
                            '<span class="fas fa-user-graduate"></span>',
                            ['administratie/student-update', 'studentid' => $model['student_id']],
                            ['class' => 'btn btn-primary', 'target' => '_blank']
                        ) ?>
                    </td>
                    <td class="hideOnExport">
                        <?= Html::a(
                            '<span class="fas fa-trash"></span>',
                            ['administratie/student-delete', 'id' => $model['student_id']],
                            ['class' => 'btn btn-danger']
                        ) ?>
                    </td>
<!--                    <td class="stud">--><?php //= Html::encode($model->no) ?><!--</td>-->
                    <td> <?= Html::activeTextInput(
                            $model,
                            "[$model->student_id]no",
                            ['class' => 'form-control']
                        ) ?></td>
                    <td class="stud"><?= Html::encode($model->naam) ?></td>
                    <td class="stud"><?= Html::encode($model->voornaam) ?></td>

                    <?php foreach ($fields as $field): ?>
                        <?php
                        $value = $model->$field;
                        $color = ($value >= 5.5 || $value == "V") ? 'green' : 'red';
                        ?>
                        <td class="form">
                            <?= Html::activeTextInput(
                                $model,
                                "[$model->student_id]$field",
                                ['class' => 'form-control', 'style' => "color: $color;"]
                            ) ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <?= Html::submitButton('Opslaan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $exportJs = <<<JS
document.getElementById('exportBtn').addEventListener('click', function() {
    const table = document.getElementById('myTable');
    let csv = '';

    table.querySelectorAll('tr').forEach(row => {
        let rowData = [];
        row.querySelectorAll('th, td').forEach(cell => {
            // Skip cells you don't want (hidden)
            if (cell.classList.contains('hideOnExport')) return;

            const input = cell.querySelector('input, textarea, select');
            let text = '';
            if (input) {
                text = (input.value || '').trim();
            } else {
                text = (cell.innerText || '').trim();
            }

            // Escape double quotes for CSV
            text = '"' + text.replace(/"/g, '""') + '"';
            rowData.push(text);
        });
        csv += rowData.join(",") + "\\n";
    });

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const filename = document.getElementById('filename').innerText.trim() + '.csv';
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
});
JS;
    $this->registerJs($exportJs);
    ?>

</div>
