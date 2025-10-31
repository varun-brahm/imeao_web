<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../mainvendor2.0/vendor/autoload.php';
require __DIR__ . '/../../mainvendor2.0/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'], // make sure your IP is allowed
    ];
}

(new yii\web\Application($config))->run();
