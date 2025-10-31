<?php
use yii\helpers\Html;

setlocale(LC_ALL, 'nld_nld');
setlocale(LC_TIME, 'nl_NL.UTF-8');

if ($results[0]['schooljaar_id']) {
    $schooljaar = \app\models\Jaar::findOne($results[0]['schooljaar_id'])->naam;
} else {
    $schooljaar = '';
}

if ($results[0]['mentor']) {
    $mentor = \app\models\Users::findOne($results[0]['mentor'])->name;
} else {
    $mentor = '';
}
?>

<link href="/css/rapport.css" rel="stylesheet">

<div class="rapport-form">
    <div id="print">
        <!-- Header -->
        <div class="report-header">
            <div class="info-box">
                <div class="info-text">
                    <h3>Instituut voor Middelbaar Economisch en Administratief Onderwijs 5</h3>
                    <p>
                        <strong>Schooljaar:</strong> <?= $schooljaar ?>
                        &nbsp;&nbsp;
                        <strong>Datum:</strong> <?= ucwords(strftime("%A %e %B %Y")) ?>
                    </p>
                </div>
                <div class="info-logo">
                    <img src="<?= Yii::getAlias('@web/statics/images/logo.png') ?>" alt="Logo">
                </div>
            </div>
        </div>

        <!-- Student Info -->
        <div class="row">
            <div class="col-5">
                <h6>Naam: <?= $results[0]['naam'] ?></h6>
                <h6>Voornaam: <?= $results[0]['voornaam'] ?></h6>
            </div>
            <div class="col-4">
                <h6>Klas: <?= $results[0]['klas'] ?></h6>
                <h6>Leerjaar: <?= $results[0]['leerjaar'] ?></h6>
            </div>
            <div class="col-3">
                <h6>Mentor: <?= $mentor ?></h6>
            </div>
        </div>

        <!-- Table -->
        <table class="table">
            <thead>
            <tr>
                <th>Vak</th>
                <th>m1t1</th>
                <th>m1t2</th>
                <th>her</th>
                <th>m2t1</th>
                <th>m2t2</th>
                <th>her</th>
                <?php if ($results[0]['leerjaar_id'] == 1): ?>
                    <th>m3t1</th>
                    <th>m3t2</th>
                    <th>her</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $behaalde_modules = 0;
            $niet_behaalde_modules = 0;
            $aantal_vakken = 0;
            $aantal_modules = 0;

            foreach ($results as $result): $aantal_vakken++; ?>
                <tr>
                    <td><?= $result['vak'] ?></td>
                    <?php
                    $module_fields = ['m1t1', 'm1t2', 'her1', 'm2t1', 'm2t2', 'her2'];
                    if ($result['leerjaar_id'] == 1) {
                        $module_fields = array_merge($module_fields, ['m3t1', 'm3t2', 'her3']);
                    }

                    foreach ($module_fields as $field) {
                        $value = $result[$field];
                        $style = ($value >= 5.5 || $value == 'V') ? 'color: black' : 'color: red';
                        echo "<td style='{$style}'>" . $value . "</td>";

                        if ($field !== 'her1' && $field !== 'her2'  && $field !== 'her3' && $field !== 'm1t2' && $field !== 'm2t2'&& $field !== 'm3t2') {
                            $aantal_modules++;
                        }

                        if ($value >= 5.5 || $value == 'V') {
                            $behaalde_modules++;
                        } else {
                            $niet_behaalde_modules++;
                        }
                    }
                    ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Footer Info -->
        <div class="row row-cols-3">
            <div class="col">
                <ul>
                    <li>NG = Niet gehaald</li>
                    <li>ND = Niet deelgenomen</li>
                </ul>
            </div>
            <div class="col">
                <h6>Verzuim(lesuren): </h6>
                <h6>Behaalde modules: <?= $behaalde_modules ?></h6>
            </div>
            <div class="col">
<!--                <h6>Niet behaalde modules: --><?php //= $aantal_modules - $behaalde_modules ?><!--</h6>-->
<!--                <h6>Wel bevorderd</h6>-->
<!--                <h6>Niet bevorderd</h6>-->
                    <h6>Wel bevorderd/ Niet bevorderd</h6>
            </div>
        </div>
<!--        <div class="row">-->
<!--            <div class="col">-->
<!--                <h5>Bevorderd/Niet bevorderd</h5>-->
<!--            </div>-->
<!--        </div>-->
<!--        <br>-->

        <div class="row row-cols-2">
            <b><h6>Module 1 datum:</h6></b>
            <b><h6>Module 2 datum:</h6></b>
        </div>

        <div class="row row-col-4">
            <div class="col">
                <hr><h6>Mentor</h6>
            </div>
            <div class="col">
                <hr><h6>Ouder</h6>
            </div>
            <div class="col">
                <hr><h6>Mentor</h6>
            </div>
            <div class="col">
                <hr><h6>Ouder</h6>
            </div>
        </div>

        <br>
        <b><h6>Eindrapport datum:</h6></b>
        <div class="row row-col-4">
            <div class="col">
                <hr><h6>Directeur</h6>
            </div>
            <div class="col">
                <hr><h6>Mentor</h6>
            </div>
        </div>

        <input type="button" id="rep" value="Print" class="btn btn-info btn_print">
    </div>

    <!-- Print Script -->
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.btn_print', function (event) {
                event.preventDefault();
                var content = document.getElementById('print');
                var printWindow = window.open('', '_blank', 'width=900,height=650');

                var styles = '';
                for (const styleSheet of document.styleSheets) {
                    try {
                        if (styleSheet.href) {
                            styles += `<link rel="stylesheet" href="${styleSheet.href}">`;
                        } else {
                            const rules = styleSheet.cssRules || styleSheet.rules;
                            if (rules) {
                                styles += '<style>';
                                for (const rule of rules) {
                                    styles += rule.cssText;
                                }
                                styles += '</style>';
                            }
                        }
                    } catch (e) {
                        // ignore CORS errors
                    }
                }

                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Print</title>
                            ${styles}
                            <style>
                                @media print {
                                    .btn_print, #rep { display: none !important; }
                                }
                            </style>
                        </head>
                        <body>
                            ${content.outerHTML}
                        </body>
                    </html>
                `);

                printWindow.document.close();
                printWindow.focus();
                setTimeout(function () {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            });
        });
    </script>
</div>
