<?php

use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;
use app\models\ModifTypeModel;
use app\models\DepotModel;
use app\models\VenteModel;
use app\models\MesAnimauxModel;
use app\models\PrevisionModel;
use app\models\FoodModel;
use app\models\StockModel;
use app\models\ResetModel;

/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// uncomment the following line for MySQL
$dsn = 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=utf8mb4';

// uncomment the following line for SQLite
// $dsn = 'sqlite:' . $config['database']['file_path'];

// Uncomment the below lines if you want to add a Flight::db() service
// In development, you'll want the class that captures the queries for you. In production, not so much.
$pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
$app->register('db', $pdoClass, [ $dsn, $config['database']['user'] ?? null, $config['database']['password'] ?? null ]);

// Got google oauth stuff? You could register that here
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis? This is where you'd set that up
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);

Flight::map('ModifTypeModel', function() {
    return new ModifTypeModel(Flight::db());  
});

Flight::map('DepotModel', function() {
    return new DepotModel(Flight::db());  
});

Flight::map('VenteModel', function() {
    return new VenteModel(Flight::db());  
});

Flight::map('MesAnimauxModel', function() {
    return new MesAnimauxModel(Flight::db());  
});

Flight::map('PrevisionModel', function() {
    return new PrevisionModel(Flight::db());  
});
Flight::map('FoodModel', function() {
    return new FoodModel(Flight::db());  
});
Flight::map('StockModel', function() {
    return new StockModel(Flight::db());  
});
Flight::map('ResetModel', function() {
    return new ResetModel(Flight::db());  
});