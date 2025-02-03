<?php

namespace app\controllers;

use app\models\MesAnimauxModel;
use Flight;

class AnimauxController {
    
    private $model;
    
    public function __construct() {

    }
    
    public function listerAnimaux() {
        $animaux = Flight::MesAnimauxModel()->listerAnimaux();
        $data = ['page' => 'liste_animaux', 'nom' => 'Liste des Animaux', 'animaux' => $animaux];
        Flight::render('template_animaux', $data);
    }
}
