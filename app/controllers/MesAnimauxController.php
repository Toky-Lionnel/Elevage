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
    


}
