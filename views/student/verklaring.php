<?php
use yii\helpers\Html;
setlocale(LC_ALL, 'nld_nld');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Verklaring</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            background: #ccc; /* grey background so border is visible on screen */
        }
        .page {
            width: 210mm;
            height: 297mm;
            background: white;
            margin: auto;
            padding: 20mm;
            box-sizing: border-box;
            border: 2px solid #000; /* border around A4 */
        }

        .header {
            margin-bottom: 20px;
        }

        .info-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid #000;
            padding: 1px 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .info-text {
            flex: 1; /* Take up available space */
        }

        .info-logo img {
            max-height: 100px; /* Adjust as needed */
            margin-left: 20px;
        }

        .section {
            margin-bottom: 20px;
            font-family: "Times New Roman", serif;
            line-height: 1.6;
            font-size: 14pt;
        }

        .footer {
            margin-top: 40px;
            font-family: "Times New Roman", serif;
            font-size: 14pt;
        }

        @media print {
            body {
                background: white;
            }
            .page {
                margin: 0;
                border: 2px solid #000;
                width: 210mm;
                height: 297mm;
            }
        }
    </style>
</head>
<body>
<div class="page">

<!--    <div class="header">-->
<!--        <div class="header-left">-->
<!--            <h1>Bewijs van inschrijving</h1>-->
<!--            <p><strong>Wanica, --><?php //= ucwords(strftime("%A %e %B %Y")) ?><!--</strong></p>-->
<!--        </div>-->
<!--        <div class="header-right">-->
<!--            <img src="--><?php //= Yii::getAlias('@web/statics/images/logo.png') ?><!--" alt="Logo">-->
<!--        </div>-->
<!--    </div>-->

    <div class="header">
        <div class="info-box">
            <div class="info-text">
                <h3>Instituut voor Middelbaar Economisch en Administratief Onderwijs 5</h3>
                <p>
                    <!--                    <strong>Email:</strong> --><?php //= ucwords(strftime("%A %e %B %Y")) ?>
                    Email: imeao.vijf@gmail.com <br>
                    Tel: 0348200
                </p>
            </div>
            <div class="info-logo">
                <img src="<?= Yii::getAlias('@web/statics/images/logo.png') ?>" alt="Logo">
            </div>
        </div>
    </div>
    <h2>Bewijs van inschrijving</h2>
    <p><strong>Wanica, <?= ucwords(strftime("%A %e %B %Y")) ?></strong></p>

    <div class="section">
        <p>
            Hierbij verklaart de directeur van het IMEAO 5
            (Instituut voor Middelbaar Economisch en Administratief Onderwijs)
            te Magentakanaal / Hoek Hanna's Lustweg,
            dat leerling <strong> <?= Html::encode($model->naam . ' ' . $model->voornaam) ?> </strong>,
            geboren op <strong><?= $model->geboorte_datum ?> </strong>
            en wonende aan de <strong><?= Html::encode($model->adres_student) ?> </strong>
            per <strong><?= (new DateTime($stud_info_asc->datum_inschrijving_her))->format('d/m/Y') ?> </strong>
            ingeschreven staat op eerdergenoemde school.
        </p>
        <p>
            Het IMEAO 5 is een mbo-school. Leerling
            <strong><?= Html::encode($model->naam . ' ' . $model->voornaam) ?></strong>
            zit/zat in het schooljaar  <strong> <?= Html::encode($stud_info_desc->jaar->naam) ?> </strong>
            in <strong> <?= Html::encode($stud_info_desc->huidige_klas) ?></strong>.
        </p>
    </div>

    <div class="footer">
        <p>Hoogachtend,</p><br><br><br>
        <p><strong>Hussain-Abdoel W. M.Ed.</strong><br>
            Directeur</p>
        <p><em>Noot: De school is niet verantwoordelijk voor onrechtmatig gebruik van deze verklaring.</em></p>
    </div>

</div>
</body>
</html>
