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
    public function listAnimalsForSaleVendre() {
        $animals = Flight::VenteModel()->getAnimalsForSaleVendre();
        Flight::render('vendre_animaux', ['animals' => $animals]);
    }

    public function acheterAnimal($id_animal) {
        // Récupération des données du POST
        $auto_vente = isset($_POST['auto_vente']) ? 0 : 1; // Si la case est cochée, auto_vente = 1
    
        $result = Flight::VenteModel()->acheterAnimal($id_animal, $auto_vente);
        if ($result) {
            Flight::redirect(constant('BASE_URL').'animaux/liste/vente'); 
        } else {
            Flight::redirect(constant('BASE_URL').'erreur'); 
        }
    }

    
    public function vendreAnimal($id_animal) {
        if (!isset($_POST['date_vente'])) {
            Flight::redirect('/erreur');
            return;
        }
    
        $date_vente = $_POST['date_vente'];
        $result = Flight::VenteModel()->vendreAnimal($id_animal, $date_vente);
    
        if ($result) {
            Flight::redirect('/animaux/liste/vente');
        } else {
            Flight::redirect('/erreur');
        }
    }
    
    
    


} 


?>