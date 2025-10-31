<?php

use app\models\Users;
use yii\bootstrap5\Html;

$user = Users::findOne(Yii::$app->user->id);
?>
<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>
            <div class="search-bar flex-grow-1">
                <div class="app-title"><?= str_replace('-',' ',strtoupper(Yii::$app->controller->action->id)) ?></div>
            </div>
            <div class="header-notifications-list">
            </div>
            <div class="header-message-list">
            </div>
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    <img src="/statics/images/avatars/user.png" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0"><?= Yii::$app->user->identity->username ?></p>
                        <p class="designattion mb-0"><?= $user->userType->name ?></p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <?=
                        Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            '<i class="bx bx-log-out-circle"></i><span>Logout</span>',
                            ['class' => 'dropdown-item']
                        )
                        . Html::endForm()
                        ?>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
