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

public function acheterAliment() {
    $id_alimentation = $_GET['id']; // Récupérer l'ID de l'aliment
    $quantite = $_GET['quantity']; // Récupérer la quantité

    if ($quantite > 0) {
        $result = Flight::FoodModel()->acheterAliment($id_alimentation, $quantite);
        if ($result) {
            Flight::redirect(constant('BASE_URL') . 'aliments/liste'); // Rediriger vers la liste après achat
        } else {
            // Gérer le cas d'argent insuffisant
            Flight::redirect(constant('BASE_URL') . 'aliments/liste?error=argent_insuffisant');
        }
    } else {
        Flight::redirect(constant('BASE_URL') . 'aliments/liste?error=quantite_invalide');
    }
}

    
} 


?>