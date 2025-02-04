<?php

namespace app\controllers;

use app\models\MesAnimauxModel;
use Flight;

class MesAnimauxController {
    
    private $model;
    
    public function __construct() {

    }
    
    public function afficherMesAnimaux() {
        $animaux = Flight::MesAnimauxModel()-> getAllMesAnimaux();
        Flight::render('liste_mes_animaux', ['animaux' => $animaux]);
    }
    public function ajouterDateMort() {
        $id_animal = $_POST['id_animal'] ?? null;
        $date_mort = $_POST['date_mort'] ?? null;

        if ($id_animal && $date_mort) {
            $this->model->updateDateMort($id_animal, $date_mort);
            Flight::redirect(constant('BASE_URL').'liste/mesanimaux'); // Redirection après mise à jour
        } else {
            Flight::redirect(constant('BASE_URL').'liste/mesanimaux?error=missing_data');
        }
    }
    
}
