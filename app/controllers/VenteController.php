<?php 

namespace app\controllers;

use app\models\VenteModel;
use Flight;

class VenteController {

    public function __construct() {

	}
    public function listAnimalsForSale() {
        $animals = Flight::VenteModel()->getAnimalsForSale();
        Flight::render('animaux_en_vente', ['animals' => $animals]);
    }

    public function acheterAnimal($id_animal) {
        $result = Flight::VenteModel()->acheterAnimal($id_animal);
        if ($result) {
            Flight::redirect(constant('BASE_URL').'animaux/liste/vente'); 
        } else {
            Flight::redirect(constant('BASE_URL').'/erreur'); 
        }
    }
    


} 


?>