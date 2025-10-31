<?php

use app\models\Recht;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

$user = Yii::$app->user->identity->recht_id;
$recht = Recht::findOne($user);

?>
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="/statics/images/logo.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <a class="text-decoration-none" href="<?=\yii\helpers\Url::to(['/dashboard/startpagina'])?>">
                <div>
                    <h4 class="logo-text"><?=Yii::$app->name?></h4>
                </div>
            </a>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="<?=\yii\helpers\Url::to(['/dashboard/startpagina'])?>">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Startpagina</div>
            </a>
        </li>
        <li class="menu-label">MENU</li>
        <?php if($recht->cijfer == 1){    ?>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="">10</i>
                </div>
                <div class="menu-title">Cijfers</div>
            </a>
            <ul>
                <?php if($recht->student_cijfer == 1){ ?>
                <li> <a href="<?=\yii\helpers\Url::to(['/administratie/student'])?>"><i class="bx bx-right-arrow-alt"></i>Student</a>
                </li>
                <?php } ?>
                <li> <a href="<?=\yii\helpers\Url::to(['/administratie/student-algeheel'])?>"><i class="bx bx-right-arrow-alt"></i>Student Algeheel</a>
                </li>
                <?php if($recht->school_cijfer == 1){ ?>
                <li> <a href="<?=\yii\helpers\Url::to(['/administratie/school'])?>"><i class="bx bx-right-arrow-alt"></i>Klas</a>
                </li>
                <?php } ?>
                <?php if($recht->moederlijst_cijfer== 1){ ?>
                <li> <a href="<?=\yii\helpers\Url::to(['/administratie/moederlijst'])?>"><i class="bx bx-right-arrow-alt"></i>Moederlijst</a>
                </li>
                <?php } ?>
            </ul>
        </li>
<!--            --><?php //if($recht->student_cijfer == 1){ ?>
<!--            <li>-->
<!--                <a href="--><?php //=\yii\helpers\Url::to(['/administratie/student-algeheel'])?><!--">-->
<!--                    <div class="parent-icon"><i class='fas fa-user-graduate'></i>-->
<!--                    </div>-->
<!--                    <div class="menu-title">Student algeheel</div>-->
<!--                </a>-->
<!--            </li>-->
<!--            --><?php //} ?>
        <?php } ?>
<!--        --><?php //if($recht->student == 1){    ?>
<!--            <li>-->
<!--                <a href="--><?php //=\yii\helpers\Url::to(['/student/student'])?><!--">-->
<!--                    <div class="parent-icon"><i class='fas fa-id-card'></i>-->
<!--                    </div>-->
<!--                    <div class="menu-title">Leerling</div>-->
<!--                </a>-->
<!--            </li>-->
<!--        --><?php //} ?>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fas fa-address-book"></i>
                </div>
                <div class="menu-title">Studenten</div>
            </a>
            <ul>
                <?php if($recht->student == 1){ ?>
                    <li> <a href="<?=\yii\helpers\Url::to(['/student/student'])?>"><i class="bx bx-right-arrow-alt"></i>Studenten</a>
                    </li>
                <?php } ?>
                <li> <a href="<?=\yii\helpers\Url::to(['/student/student-algeheel'])?>"><i class="bx bx-right-arrow-alt"></i>Algeheel</a>
                </li>
            </ul>
        </li>
        <?php if ($recht->user == 1){ ?>
            <li><a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-customize"></i>
                    </div>
                    <div class="menu-title">Managment</div>
                </a>
                <ul>
                    <?php if ($recht->user_user == 1){ ?>
                    <li>
                    <a href="<?=\yii\helpers\Url::to(['/configuratie/gebruiker'])?>">
                        <div class="parent-icon"><i class='bx bxs-user-pin'></i>
                        </div>
                        <div class="menu-title">Gebruikers</div>
                    </a>
                </li>
                    <?php } ?>
                    <?php if($recht->user_recht == 1){ ?>
                    <li> <a href="<?=\yii\helpers\Url::to(['/configuratie/recht'])?>"><i class="bx bx-right-arrow-alt"></i>Rechten</a>
                    </li>
                    <?php } ?>
                    <?php if($recht->user_recht == 1){ ?>
                        <li> <a href="<?=\yii\helpers\Url::to(['/configuratie/log-view'])?>"><i class="bx bx-right-arrow-alt"></i>Log</a>
                        </li>
                        <li> <a href="<?=\yii\helpers\Url::to(['/referentie/leerjaarvak'])?>"><i class="bx bx-right-arrow-alt"></i>Leerjaar Vak</a>
                        </li>
                        <li> <a href="<?=\yii\helpers\Url::to(['/referentie/vak'])?>"><i class="bx bx-right-arrow-alt"></i>Vak</a>
                        </li>
                    <?php } ?>

                </ul>
            </li>
        <?php } ?>
    </ul>
    <!--end navigation-->
</div>