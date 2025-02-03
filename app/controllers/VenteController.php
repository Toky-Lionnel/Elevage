<?php 

namespace app\controllers;

use app\models\VenteModel;
use Flight;

class VenteController {

    public function __construct() {

	}
    public function listAnimalsForSale() {
        $animals = Flight::AnimalModel()->getAnimalsForSale();
        Flight::render('animaux_en_vente', ['animals' => $animals]);
    }


} 


?>