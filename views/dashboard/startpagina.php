<?php

use hoaaah\ajaxcrud\CrudAsset;
use yii\helpers\Html;

$user = \app\models\Users::findOne(Yii::$app->user->id);
$recht = \app\models\Recht::findOne($user->recht_id);

CrudAsset::register($this);
?>
<style>
    img {
        display: block;
        margin: 0 auto;
    }
</style>
<div class="startpagina-index">
    <h1><?= Yii::$app->user->identity->fullname?> welkom bij de studenten en cijfers bestand van IMEAO-5. <br>U bent ingelogd als <?= $recht->naam ?></h1>
    <img src="<?= Yii::getAlias('@web/statics/images/logo.png') ?>" alt="Logo">
</div>
</div>

