<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use hoaaah\ajaxcrud\CrudAsset;
use yii\helpers\Url;

setlocale(LC_ALL, 'nld_nld');

$schooljaar  = \app\models\Jaar::findOne($results[0]['schooljaar_id'])->naam;
?>

<div class="rapport-form">
    <style>
        body{
            background-color: white;
        }
        table {
            font-family: "Times New Roman", sans-serif;
            border-collapse: collapse;
            width: 95%;
            border: 1px solid black;


        }

        td, th {
            border: 1px solid #000000;
            text-align: left;
            padding: 100px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        #filename {
            display: none;
        }

        hr{
            color: black;
            border-top: 1px solid rgb(0 0 0);
            height: 2px;
        }

        #print{
            transform: scale(1.0 , 0.8);
        }

    </style>

<div id="print" >
    <div class="row">
        <div class="col-md-6">
            <h6 >Naam: <?= $results[0]['naam'] ?></h6>
            <h6>Voornaam: <?= $results[0]['voornaam'] ?></h6>
            <h6>Mentor: <?= $results[0]['mentor'] ?></h6>
        </div>
        <div class="col-md-4">
            <h6 >Klas: <?= $results[0]['klas'] ?></h6>
            <h6>Schooljaar: <?= $schooljaar ?></h6>
        </div>

<!--    <h6>School: IMEAO-5</h6>-->
<!--    <h6>Datum: --><?php //= ucwords(strftime("%A %e %B %Y")) ?><!--</h6>-->
<!--    <h6>Leerjaar: --><?php //= $results[0]['leerjaar'] ?><!--</h6>-->



</div>
    <h6 id="filename"><?= $results[0]['naam']?> rapport</h6>
    <table class="table">
        <thead>
        <tr>
         <b>  <th>Vak</th>
            <th>m1t1</th>
            <th>m1t2</th>
            <th>m2t1</th>
            <th>m2t2</th>
            <?php if ($results[0]['leerjaar_id'] == 1): ?>
                <th>m3t1</th>
                <th>m3t2</th></b>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>

        <?php
        $behaalde_modules = 0;
        foreach ($results as $result): ?>
            <tr>

                <td><?= $result['vak'] ?></td>
                <?php

                $value = $result["m1t1"];
                if ($value >= 5.5 || $value == "V" ) {
                    echo "<td style='color: green'>" . $result["m1t1"] . "</td>";
                    $behaalde_modules++;
                }else{
                    echo "<td style='color: red'>" . $result["m1t1"] . "</td>";}


                 $value = $result["m1t2"];
                if ($value >= 5.5 || $value == "V" ) {
                    echo "<td style='color: green'>" . $result["m1t2"] . "</td>";
                    $behaalde_modules++;
                }else{
                    echo "<td style='color: red'>" . $result["m1t2"] . "</td>";}



                  $value = $result["m2t1"];
                if ($value >= 5.5 || $value == "V" ) {
                    echo "<td style='color: green'>" . $result["m2t1"] . "</td>";
                    $behaalde_modules++;
                }else{
                    echo "<td style='color: red'>" . $result["m2t1"] . "</td>";}


                $value = $result["m2t2"];
                if ($value >= 5.5 || $value == "V" ) {
                echo "<td style='color: green'>" . $result["m2t2"] . "</td>";
                    $behaalde_modules++;
                }else{
                echo "<td style='color: red'>" . $result["m2t2"] . "</td>";}

               ?>

                <?php if ($result['leerjaar_id'] == 1):

                    $value = $result["m3t1"];
                    if ($value >= 5.5 || $value == "V" ) {
                    echo "<td style='color: green'>" . $result["m3t1"] . "</td>";
                        $behaalde_modules++;
                   }else{
                   echo "<td style='color: red'>" . $result["m3t1"] . "</td>";}

                     $value = $result["m3t2"];
                    if ($value >= 5.5 || $value == "V" ) {
                    echo "<td style='color: green'>" . $result["m3t2"] . "</td>";
                        $behaalde_modules++;
                   }else{
                   echo "<td style='color: red'>" . $result["m3t2"] . "</td>";} ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="row row-cols-3">
        <div class="col">
            <ul>
                <li>NG = Niet gehaald </li>
                <li>ND = Niet deelgenomen</li>
            </ul>
        </div>
        <div class="col">
            <h6>Verzuim(lesuren): </h6>
            <h6>Behaalde modules: <?php echo $behaalde_modules?>  </h6>
        </div>

    </div>
<div class="row row-cols-2">
    <b><h6>Module 1 datum:</h6></b>
    <b><h6> Module 2 datum:</h6></b>
</div>
    <div class="row row-col-4">
        <div class="col">
            <hr>
            <h6>Mentor</h6>
        </div>
        <div class="col">
            <hr>
            <h6>Ouder</h6>
        </div>
        <div class="col">
            <hr>
            <h6>Mentor</h6>
        </div>
        <div class="col">
            <hr>
            <h6>Ouder</h6>
        </div>
    </div>
    <br>
<!--    <b><h6> Module 2</h6></b>-->
<!--    <div class="row row-col-4">-->
<!--        <div class="col">-->
<!--            <hr>-->
<!--            <h6>Mentor</h6>-->
<!--        </div>-->
<!--        <div class="col">-->
<!--            <hr>-->
<!--            <h6>Ouder</h6>-->
<!--        </div>-->
<!--        <div class="col">-->
<!--        </div>-->
<!--    </div>-->
    <br>
    <b><h6> Eindrapport datum: </h6></b>
    <div class="row row-col-4">
        <div class="col">
            <hr>
            <h6>Directeur</h6>
        </div>
        <div class="col">
            <hr>
            <h6>Mentor</h6>
        </div>
        <div class="col"></div>
        <div class="col"></div>

    </div>


</div>
    <input type="button" id="rep" value="Print" class="btn btn-info btn_print">
<!--        <script type="text/javascript">-->
<!--            // window.onload = function() {-->
<!--            //     document.getElementById("rep").click();-->
<!--            // }-->
<!--                    $(document).ready(function($) {-->
<!--                    $(document).on('click', '.btn_print', function(event) {-->
<!--                        event.preventDefault();-->
<!---->
<!--                        var content = document.getElementById('print').innerHTML;-->
<!---->
<!--                        var printWindow = window.open('', '', 'height=800,width=600');-->
<!--                        printWindow.document.write('<html><head><title>Print</title>');-->
<!--                        printWindow.document.write('<style>body{ font-family: Arial; padding: 2cm; }</style>'); // optional styles-->
<!--                        printWindow.document.write('</head><body>');-->
<!--                        printWindow.document.write(content);-->
<!--                        printWindow.document.write('</body></html>');-->
<!---->
<!--                        printWindow.document.close(); // necessary for IE >= 10-->
<!--                        printWindow.focus();          // necessary for IE >= 10-->
<!---->
<!--                        printWindow.print();-->
<!--                        // printWindow.close();-->
<!--                    });-->
<!--                });-->
<!---->
<!--            // $(document).ready(function($) {-->
<!--            //     var filename = document.getElementById("filename").innerText;-->
<!--                // $(document).on('click', '.btn_print', function(event) {-->
<!--                //     event.preventDefault();-->
<!--                //-->
<!--                //     var element = document.getElementById('print');-->
<!--                //     var opt = {-->
<!--                //         margin:       1,-->
<!--                //         filename:     filename,-->
<!--                //         image:        { type: 'jpeg', quality: 0.98 },-->
<!--                //         html2canvas:  { scale: 3 },-->
<!--                //         jsPDF:        { unit: 'cm', format: 'a4', orientation: 'portrait' },-->
<!--                //         pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }-->
<!--                //     };-->
<!--                //-->
<!--                //     html2pdf().set(opt).from(element).save();-->
<!--                    //html2pdf().set(opt).from(element).toPdf().get('pdf').then(function(pdf) {-->
<!--                    //    var blob = new Blob([pdf.output('blob')], { type: 'application/pdf' });-->
<!--                    //-->
<!--                    //    // Create FormData object-->
<!--                    //    var formData = new FormData();-->
<!--                    //    formData.append(blob);-->
<!--                    //-->
<!--                    //-->
<!--                    //    $.ajax({-->
<!--                    //        url: '--><?php ////echo Yii::$app->urlManager->createUrl(["administratie/upload"]); ?>////',
//                    //        type: 'POST',
//                    //        data: formData,
//                    //        processData: false,
//                    //        contentType: false,
//                    //        success: function(response) {
//                    //            console.log('PDF saved on the server:', response);
//                    //        },
//                    //        error: function(xhr, status, error) {
//                    //            console.error('Error saving PDF on the server:', error);
//                    //        }
//                    //    });
//                    });
//                });
<!--        </script> -->

    <script type="text/javascript">
        $(document).ready(function($) {
            $(document).on('click', '.btn_print', function(event) {
                event.preventDefault();

                // Get the content to print
                var content = document.getElementById('print');

                // Open new window
                var printWindow = window.open('', '', 'width=900,height=650');

                // Write HTML to new window
                printWindow.document.write('<html><head><title>Print</title>');
                // Optionally reuse your external CSS file:
                // printWindow.document.write('<link rel="stylesheet" href="/css/site.css" type="text/css" />');
                printWindow.document.write('<style>');
                printWindow.document.write(`
                body { font-family: "Times New Roman", sans-serif; padding: 1cm; background-color: white; }
                table { border-collapse: collapse; width: 95%; border: 1px solid black; }
                th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                tr:nth-child(even) { background-color: #dddddd; }
                h6 { margin: 4px 0; }
                hr { border-top: 1px solid black; }
            `);
                printWindow.document.write('</style></head><body>');
                printWindow.document.write(content.outerHTML);
                printWindow.document.write('</body></html>');

                printWindow.document.close();
                printWindow.focus();

                // Wait a little before printing
                setTimeout(function () {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            });
        });
    </script>





</div>


