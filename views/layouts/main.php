<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use hoaaah\ajaxcrud\CrudAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
$this->title = strtoupper(Yii::$app->name.' | '.str_replace('-',' ',Yii::$app->controller->action->id));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="/statics/images/logo.png" type="image/png" />
    <link href="/css/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="/css/bootstrap-half-and-quarter-grid/fractional-grid.min.css" rel="stylesheet">
    <script src="/js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<style>
    .table > :not(:first-child) {
        border-top: 1px solid #dee2e6;
    }
    .table th,tr,td{
        border: 1px solid #dee2e6;
    }
    .btn-xs
    {
        padding: 1px 5px !important;
        font-size: 12px !important;
        line-height: 1.5 !important;
        border-radius: 3px !important;
    }
    .switcher-btn {
        top: 50%;
    }
</style>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <!--sidebar wrapper -->
    <?= $this->render('sidebar.php' ) ?>
    <!--end sidebar wrapper -->
    <!--start header -->
    <?= $this->render('header.php' ) ?>
    <!--end header -->
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    <footer class="page-footer">
<!--        <p class="mb-0">© --><?php //= Yii::$app->name.' '.date('Y')?><!--. Powered by <a href="https://bdsnv.com/" target="_blank">BDSNV</a>.</p>-->
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>




