<?php
//
////return [
////    'class' => 'yii\db\Connection',
////    'driverName' => 'sybase',
////    'schemaMap' => [
////        'sybase' => \websightnl\yii2\sybase\Schema::className(),
////    ],
////    'pdoClass'=> '\websightnl\yii2\sybase\PDO',
////    'dsn' => 'odbc:tank_systeem',
////    'username' => 'dba',
////    'password' => 'sql',
////    'charset' => 'utf8',
////
////    // Schema cache options (for production environment)
////    'enableSchemaCache' => true,
////    'schemaCacheDuration' => 60,
////    'schemaCache' => 'cache',
////];
//
//
////return [
////    'class' => 'yii\db\Connection',
////    'dsn' => 'mysql:host=192.168.100.2;dbname=imeao_web',
////    'username' => 'yii2',
////    'password' => 'yii2',
////    'charset' => 'utf8mb4',
////
////    // Schema cache options (for production environment)
////    'enableSchemaCache' => true,
////    'schemaCacheDuration' => 60,
////    'schemaCache' => 'cache',
////];
//
//return [
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=192.168.132.129;dbname=imeao_web',
//    'username' => 'varun',
//    'password' => 'Varun%123',
//    'attributes' => [
//        'attributes' => [
//            PDO::MYSQL_ATTR_SSL_CA     => 'C:/web/certs/ca-cert.pem',
//            PDO::MYSQL_ATTR_SSL_CERT   => 'C:/web/certs/client-cert.pem',
//            PDO::MYSQL_ATTR_SSL_KEY    => 'C:/web/certs/client-key.pem',
//        ],
//    ],
//    'charset' => 'utf8mb4',
//        // Schema cache options (for production environment)
//    'enableSchemaCache' => true,
//    'schemaCacheDuration' => 60,
//    'schemaCache' => 'cache',
//];
//
//
//return [
//    'class' => 'yii\db\Connection',
////    'dsn' => 'mysql:host=192.168.132.129;dbname=imeao_web',  // IP must match cert CN
//    'dsn' => 'mysql:host=192.168.18.121;dbname=imeao_web2',
//    'username' => 'varun',
//    //'password' => 'Varun%123',
//     'password' => '1qaz@WSX3edc',
////    'attributes' => [
////        PDO::MYSQL_ATTR_SSL_CA => 'C:/web/certs2/ca-cert.pem',
////        PDO::MYSQL_ATTR_SSL_CERT => 'C:/web/certs2/client-cert.pem',
////        PDO::MYSQL_ATTR_SSL_KEY => 'C:/web/certs2/client-key.pem',
////    ],
//    'attributes' => [
//        PDO::MYSQL_ATTR_SSL_CA => 'C:/web/certs/ca-cert.pem',
//        PDO::MYSQL_ATTR_SSL_CERT => 'C:/web/certs/client-cert.pem',
//        PDO::MYSQL_ATTR_SSL_KEY => 'C:/web/certs/client-key.pem',
//    ],
//    'charset' => 'utf8mb4',
//    'enableSchemaCache' => true,
//    'schemaCacheDuration' => 120,
//    'schemaCache' => 'cache',
//];

//return [
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=192.168.132.129;dbname=imeao',  // IP must match cert CN
////    'dsn' => 'mysql:host=10.0.1.4;dbname=imeao_web',
////    'dsn' => 'mysql:host=192.168.18.121;dbname=imeao_web',
//    'username' => 'varun',
//    'password' => 'Varun%123',
////    'password' => '4rfv%TGB6yhn',
//    'attributes' => [
//        PDO::MYSQL_ATTR_SSL_CA => 'C:/web/certs2/ca-cert.pem',
//        PDO::MYSQL_ATTR_SSL_CERT => 'C:/web/certs2/client-cert.pem',
//        PDO::MYSQL_ATTR_SSL_KEY => 'C:/web/certs2/client-key.pem',
//    ],
//    'charset' => 'utf8mb4',
//    'enableSchemaCache' => true,
//    'schemaCacheDuration' => 120,
//    'schemaCache' => 'cache',
//];

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=imeao_web',
    'username' => 'root',
    'password' => '1qaz@WSX3edc',
    'charset' => 'utf8mb4',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 120,
    'schemaCache' => 'cache',
];

//return [
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=192.168.132.129;dbname=imeao_web',
//    'username' => 'web',
//    'password' => '4rfv%TGB6yhn',
//    'charset' => 'utf8mb4',
//    'enableSchemaCache' => true,
//    'schemaCacheDuration' => 120,
//    'schemaCache' => 'cache',
//];