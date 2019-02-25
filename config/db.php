<?php

/**
 * @var array $params
 */

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$params['db.host'].';dbname='.$params['db.name'],
    'username' => $params['db.username'],
    'password' => $params['db.password'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
