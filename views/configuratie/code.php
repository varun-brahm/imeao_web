<?php

use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer as QrCodeWriter;
use yii\helpers\Html;

$this->title = 'Two-Factor Authentication';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-2fa">

    <?php
    $key = \app\models\Users::findOne($id)->auth_key;
    $username = \app\models\Users::findOne($id)->username;
    $content ='otpauth://totp/'.'IMEAO'.'?secret='.$key;
        ?>
    <h1><?= Html::encode($this->title) ?></h1>
<style>
    #qr{
        transform: scale(3);
    }
</style>

<!--  <img id="qr" src=--><?php //= $qrCodeDataUri?><!-- >-->

    <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($content) ?>" title="HELLO" />

<!--    --><?php //= Html::img($qrCodeDataUri, ['alt' => 'QR Code']) ?>


</div>
