<?php 

namespace app\controllers;

use app\models\ResetModel;
use Flight;

class ResetController {

    public function __construct() {

	}

    public function reset() {
        $result = Flight::ResetModel()->reinitialiserDonnees();
        if ($result) {
            Flight::redirect(constant('BASE_URL').'liste/stock'); // Rediriger vers la liste du stock après réinitialisation
        } else {
            Flight::render('erreur', ['message' => 'Erreur lors de la réinitialisation des données']);
        }
    }
    

    
    


} 


?>