<?php 

namespace app\controllers;

use app\models\VenteModel;
use Flight;

class StockController {

    public function __construct() {

	}

    public function afficherStock() {
        $stocks = Flight::StockModel()->getStockDetails();
        Flight::render('liste_stock', ['stocks' => $stocks]);
    }
    
    


} 


?>