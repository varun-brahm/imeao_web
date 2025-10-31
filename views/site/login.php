<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("
$(document).ready(function () {
        $('#show_hide_password a').on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr('type') == 'text') {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass('bx-hide');
                $('#show_hide_password i').removeClass('bx-show');
            } else if ($('#show_hide_password input').attr('type') == 'password') {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass('bx-hide');
                $('#show_hide_password i').addClass('bx-show');
            }
        });
    });

",3)
?>
<div class="container-fluid">
    <div class="row row-cols-1   row-cols-lg-3 row-cols-xl-4">
        <div class="col mx-auto">
            <div class="card mt-5 mt-lg-0">
                <div class="card-body">
                    <div class="border p-4 rounded">
                        <div class="text-center">
                            <h3 class="">Login</h3>
                        </div>
                        <div class="form-body">
                            <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class'=>'row g-3']]) ?>
                            <div class="col-12">
                                <label for="inputEmailAddress" class="form-label">Gebruikersnaam</label>
                                <input type="text" name="LoginForm[username]" value="<?=$model->username?>" class="form-control" id="inputEmailAddress" placeholder="Gebruikersnaam" required>
                            </div>
                            <div class="col-12">
                                <label for="inputChoosePassword" class="form-label">Wachtwoord</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" name="LoginForm[password]" value="<?=$model->password?>" class="form-control border-end-0" id="inputChoosePassword" placeholder="Wachtwoord" required> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="inputTwoFactorCode" class="form-label">Two-Factor Authentication Code</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="text" name="LoginForm[auth_key]" class="form-control border-end-0" id="inputTwoFactorCode" placeholder="Enter your 2FA code" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Login</button>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
</div>