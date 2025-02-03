<?php 

namespace app\controllers;

use app\models\FoodModel;
use Flight;

class FoodController {

    public function __construct() {

	}

    public function listAliments() {
        $aliments = Flight::FoodModel()->getAllAliments();
        Flight::render('liste_aliments', ['aliments' => $aliments]);
    }
    
} 


?>