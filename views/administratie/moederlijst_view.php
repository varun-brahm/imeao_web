<?php

use app\models\School;
use app\models\Studentcijfer;
use app\models\Vak;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use hoaaah\ajaxcrud\CrudAsset;
use yii\helpers\Url;

?>

<div class="school-form">
    <style>
        table {
            font-family: "Times New Roman", sans-serif;
            border-collapse: collapse;
            width: 500px;
            border: 1px solid black;
        }

        td, th {
            border: 1px solid #000000;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .sticky-header {
            position: sticky;
            top: 0;
            background-color: white;
        }

        tr:hover {
            background-color: #ffff99 !important;
        }
    </style>

    <?php $klas = School::findOne($klas_id); ?>
    <h1 id="filename"><?= $klas->Klas ?> Moederlijst</h1>
    <div style="overflow-x: scroll;">
        <table class="table" style="white-space: nowrap;" id="myTable" border="1">
            <thead>
            <tr class="red">
                <th class="sticky-header">Naam</th>
                <th class="sticky-header">Voornaam</th>
                <th colspan="2">Vak</th>
            </tr>
            <tr>
                <th class="sticky-header"></th>
                <th class="sticky-header"></th>

                <?php
                // collect vak IDs
                $uniqueVakIds = array_unique(array_column($allCijfers, 'vak_id'));

                function myTest($counter) {
                    return $counter % 4;
                }

                // define all columns per vak
                $fields = [
                    'm1t1',
                    'm1t2',
                    'her1',
                    'm2t1',
                    'm2t2',
                    'her2'
                ];
                if ($klas->leerjaar_id == 1) {
                    $fields = array_merge($fields, ['m3t1', 'm3t2', 'her3']);
                }

                $counter = 0;
                foreach ($uniqueVakIds as $vakId):
                    $vak_naam = Vak::findOne($vakId)->vak;
                    $counter++;
                    $colspan = count($fields);

                    echo "<th colspan='{$colspan}'>{$vak_naam}</th>";

                    $answer = myTest($counter);
                    if ($answer == 0) {
                        echo "<th>Naam</th>";
                        echo "<th>Voornaam</th>";
                    }
                endforeach;
                ?>

                <th>Voldoende</th>
            </tr>
            <tr>
                <th class="sticky-header"></th>
                <th class="sticky-header"></th>
                <?php
                $counter = 0;
                foreach ($uniqueVakIds as $vakId):
                    $counter++;
                    $answer = myTest($counter);

                    // output field headers for this vak
                    foreach ($fields as $f) {
                        echo "<th>{$f}</th>";
                    }

                    if ($answer == 0) {
                        echo "<th></th>";
                        echo "<th></th>";
                    }

                endforeach;
                ?>
            </tr>
            </thead>
            <tbody>

            <?php
            $namen = Studentcijfer::find()
                ->where(['klas_id' => $allCijfers[0]['klas_id']])
                ->all();
            $counter = 0;

            foreach ($namen as $naam): ?>
                <tr>
                    <td class="sticky-header"><?= $naam["naam"] ?></td>
                    <td class="sticky-header"><?= $naam["voornaam"] ?></td>

                    <?php
                    $klas_naam = School::findOne($klas_id)->Klas;
                    $allklas = School::find()->where(['Klas' => $klas_naam])->all();
                    $voldoende_counter = 0;
                    $onvoldoende_counter = 0;

                    foreach ($allklas as $klas):
                        $counter++;
                        $klasid = $klas["klas_id"];
                        $cijfer = Studentcijfer::find()
                            ->where(['klas_id' => $klasid])
                            ->andWhere(['naam' => $naam['naam']])
                            ->one();

                        // output all columns from $fields
                        foreach ($fields as $field) {
                            if (isset($cijfer[$field])) {
                                $value = $cijfer[$field] ?? 0;
                                if ($value >= 5.5 || $value == "V") {
                                    echo "<td style='color: black'>" . ($cijfer[$field] ?? "") . "</td>";
                                    $voldoende_counter++;
                                } else {
                                    echo "<td style='color: red'>" . ($cijfer[$field] ?? "") . "</td>";
                                    $onvoldoende_counter++;
                                }
                            } else {
                                echo "<td></td>";
                            }
                        }

                        $answer = myTest($counter);
                        if ($answer == 0): ?>
                            <td><?= $naam["naam"] ?></td>
                            <td><?= $naam["voornaam"] ?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php
                    echo "<td style='color: green'>" . $voldoende_counter . "</td>";
                    $counter = 0;
                    ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button id="exportBtn">Export Table to Excel</button>

        <script>
            $(document).ready(function () {
                $("#exportBtn").click(function () {
                    var filename = document.getElementById("filename").innerText;
                    exportTableToExcel('myTable', filename);
                });
            });

            function exportTableToExcel(tableID, filename) {
                var tableSelect = document.getElementById(tableID);
                var tableHTML = tableSelect.outerHTML;

                filename = filename ? filename + '.xls' : 'excel_data.xls';

                // Add UTF-8 meta to ensure characters are preserved
                var html = `
            <html xmlns:x="urn:schemas-microsoft-com:office:excel">
            <head>
                <meta charset="UTF-8">
            </head>
            <body>
                ${tableHTML}
            </body>
            </html>`;

                var blob = new Blob([html], { type: "application/vnd.ms-excel;charset=utf-8;" });

                if (navigator.msSaveOrOpenBlob) {
                    navigator.msSaveOrOpenBlob(blob, filename);
                } else {
                    var downloadLink = document.createElement("a");
                    downloadLink.href = URL.createObjectURL(blob);
                    downloadLink.download = filename;
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                }
            }
        </script>

    </div>
</div>
