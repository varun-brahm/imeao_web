<?php

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
            width: 100%;
            min-width: 1700px;
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
        th {
            background: white;
            position: sticky;
            top: 0; /* Don't forget this, required for the stickiness */
            box-shadow: 2px 2px 2px 2px darkred;
            border: 1px solid darkred;
        }
        tr.red th {
            background: white;
            color: black;
            border: 1px solid darkred;
        }
        /*td{*/
        /*    border: black ;*/
        /*}*/
    </style>
    <?php $form = ActiveForm::begin([
        'id' => 'school_form',
        'options' => [
//            'enctype' => 'multipart/form-data',
//            'target' => '_self'
        ]
    ]); ?>

    <div style="overflow-x: auto; white-space: nowrap; width: 100%;">
    <table class="table">
        <thead>
        <tr class="red">
<!--            <th>ID</th>-->
            <th>Naam</th>
            <th>Voornaam</th>
            <th>m1t1</th>
            <th>m1t2</th>
            <th>m2t1</th>
            <th>m2t2</th>
            <th>m3t1</th>
            <th>m3t2</th>
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

            <!-- Add other columns as needed -->
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $model): ?>
            <?php
            $value = $model->m1t1;

            $color = ($value < 5.5) ? 'green' : 'red';
            ?>

            <style>
                .cijfer {
                    color: <?= $color ?>;
                }
            </style>

            <tr>
<!--                <td>--><?php //= Html::encode($model->student_id) ?><!--</td>-->
                <td><?= Html::encode($model->naam) ?></td>
                <td><?= Html::encode($model->voornaam) ?></td>

                    <?php

                    $value = $model->m1t1;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo ' <td style="background-color: green">';
                        echo Html::activeTextInput($model, "[$model->student_id]m1t1", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo ' <td style="background-color: red">';
                        echo Html::activeTextInput($model, "[$model->student_id]m1t1", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>

                </td>

                    <?php
                    $value = $model->m1t2;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo ' <td style="background-color: green">';
                        echo Html::activeTextInput($model, "[$model->student_id]m1t2", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo ' <td style="background-color: red">';
                        echo Html::activeTextInput($model, "[$model->student_id]m1t2", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>

                    <?php
                    $value = $model->m2t1;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo ' <td style="background-color: green">';
                        echo Html::activeTextInput($model, "[$model->student_id]m2t1", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo ' <td style="background-color: red">';
                        echo Html::activeTextInput($model, "[$model->student_id]m2t1", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>

                    <?php
                    $value = $model->m2t2;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo ' <td style="background-color: green">';
                        echo Html::activeTextInput($model, "[$model->student_id]m2t2", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo ' <td style="background-color: red">';
                        echo Html::activeTextInput($model, "[$model->student_id]m2t2", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m3t1;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m3t1", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m3t1", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m3t2;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m3t2", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m3t2", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m1h1;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m1h1", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m1h1", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m1h2;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m1h2", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m1h2", ['class' => 'form-control', 'style' => 'color: red;']);
                    }                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m1h3;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m1h3", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m1h3", ['class' => 'form-control', 'style' => 'color: red;']);
                    }                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m1h4;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m1h4", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m1h4", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m2h1;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m2h1", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m2h1", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m2h2;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m2h2", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m2h2", ['class' => 'form-control', 'style' => 'color: red;']);
                    }                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m2h3;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m2h3", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m2h3", ['class' => 'form-control', 'style' => 'color: red;']);
                    }                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m2h4;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m2h4", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m2h4", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m3h1;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m3h1", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m3h1", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m3h2;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m3h2", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m3h2", ['class' => 'form-control', 'style' => 'color: red;']);
                    }                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m3h3;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m3h3", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m3h3", ['class' => 'form-control', 'style' => 'color: red;']);
                    }                    ?>
                </td>
                <td>
                    <?php
                    $value = $model->m3h4;
                    if ($value >= 5.5 || $value == "V" ) {
                        echo Html::activeTextInput($model, "[$model->student_id]m3h4", ['class' => 'form-control' , 'style' => 'color: green;']);
                    } else {
                        echo Html::activeTextInput($model, "[$model->student_id]m3h4", ['class' => 'form-control', 'style' => 'color: red;']);
                    }
                    ?>
                </td>
                <td>
                    <?php
                    echo Html::a(
                        '<span class="fas fa-times"></span>',
                        ['administratie/student-delete', 'id' => $model['student_id']],
                        [
                            'class' => 'btn btn-danger',
                            'onclick' => "return confirm('Are you sure you want to delete this student?');"
                        ]
                    );

                    ?>
                </td>
                <td>
                    <?php
                    echo Html::a(
                        '<span class="fas fa-file-pdf"></span>',
                        ['administratie/student-rapport', 'studentid' => $model['student_id']],
                        [
                            'class' => 'btn btn-primary',
                            'target'=>'_blank'
                        ]
                    );

                    ?>
                </td>
                <td>
                    <?php
                    echo Html::a(
                        '<span class="fas fa-user-graduate"></span>',
                        ['administratie/student-update', 'studentid' => $model['student_id']],
                        [
                            'class' => 'btn btn-primary',
                            'target'=>'_blank'
                        ]
                    );

                    ?>
                </td>


            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
<!--        --><?php //= Html::a('<span class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="student toevoegen"> Student toevoegen</span>',
//            ['student-create', 'id' => $model->cijferid],
//            [
//                'role' => 'modal-remote',
//                'class' => 'btn btn-success',
//                'id' => 'studentCreateButton',
//            ]
//        ).
//        Html::a(
//            '<span class="fas fa-times"></span>',
//            ['administratie/student-create', 'id' => $model['cijferid']],
//            ['class' => 'btn btn-danger','role' => 'modal-remote',]
//        )
//        ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // // jQuery document ready function to ensure the DOM is fully loaded
            // $(document).ready(function() {
            //     // Add a click event listener to the button using jQuery
            //     $('#studentCreateButton').click(function(event) {
            //         // Prevent the default action (e.g., following the link or submitting the form)
            //         event.preventDefault();
            //
            //         // Your code here
            //
            //     var url = $(this).attr('href');
            //
            //
            //     $.ajax({
            //         url: url,
            //         type: 'GET',
            //         dataType: 'json',
            //         success: function(data) {
            //             $('#ajaxCrudModal .modal-title').html(data.title);
            //             $('#ajaxCrudModal .modal-body').html(data.content);
            //             $('#ajaxCrudModal .modal-footer').html(data.footer);
            //             $('#ajaxCrudModal').modal('show');
            //
            //         },
            //         error: function(jqXHR, textStatus, errorThrown) {
            //             console.error('AJAX Error:', textStatus, errorThrown);
            //         }
            //     });
            // });
            // });


            //
            // $(document).on('click', '#saveButton', function() {
            //     var form = $('#ajaxCrudModal'); // Assuming your form has an ID of "melding_form"
            //     var formData = form.serialize(); // Serialize form data
            //     console.log("Submit clicked")
            //
            //     $.ajax({
            //         url: form.attr('student-create'), // URL to submit form data to
            //         type: form.attr('POST'), // HTTP method (GET or POST)
            //         data: formData, // Form data to submit
            //         dataType: 'html',
            //         success: function(data) {
            //             // Handle the success response from the server
            //             // For example, close the modal after successful submission
            //             console.log("success")
            //             $('#ajaxCrudModal').modal('hide');
            //         },
            //         error: function(xhr, status, error) {
            //             // Handle errors
            //             console.error('AJAX error:', status, error);
            //         }
            //     });
            // });
        </script>


    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
<?php Modal::begin([
    "options"=>[
        'tabindex' => false
    ],
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
    "size"=>"modal-lg",
])?>
<?php Modal::end(); ?>
