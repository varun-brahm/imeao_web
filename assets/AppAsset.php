<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
        'statics/plugins/simplebar/css/simplebar.css',
        'statics/plugins/perfect-scrollbar/css/perfect-scrollbar.css',
        'statics/plugins/metismenu/css/metisMenu.min.css',
        'statics/plugins/datatable/css/dataTables.bootstrap5.min.css',
        'statics/plugins/vectormap/jquery-jvectormap-2.0.2.css',
        'statics/plugins/highcharts/css/highcharts.css',

        'statics/css/pace.min.css',

        'statics/css/bootstrap.min.css',
        'statics/css/bootstrap-extended.css',
        'statics/css/app.css',
        'statics/css/icons.css',

        'statics/css/dark-theme.css',
        'statics/css/semi-dark.css',
        'statics/css/header-colors.css'
    ];
    public $js = [
//        'bootstrap/js/bootstrap.bundle.min.js',
//        'statics/js/bootstrap.bundle.min.js',
//        'statics/js/jquery.min.js',
        'statics/js/pace.min.js',
        'statics/plugins/simplebar/js/simplebar.min.js',
        'statics/plugins/metismenu/js/metisMenu.min.js',
        'statics/plugins/perfect-scrollbar/js/perfect-scrollbar.js',
//        'statics/plugins/apexcharts-bundle/js/apexcharts.min.js',
//        'statics/plugins/datatable/js/jquery.dataTables.min.js',
//        'statics/plugins/datatable/js/dataTables.bootstrap5.min.js',
//        'statics/plugins/vectormap/jquery-jvectormap-2.0.2.min.js',
//        'statics/plugins/vectormap/jquery-jvectormap-world-mill-en.js',
//        'statics/plugins/highcharts/js/highcharts.js',
//        'statics/plugins/apexcharts-bundle/js/apexcharts.min.js',

        'statics/js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
