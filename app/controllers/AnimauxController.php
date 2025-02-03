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

    public function nourrirAnimal($idAnimal){
        if (!isset($_POST['dateAlimentation'])) {
            // Gérer l'erreur si la date n'est pas envoyée
            die("Date d'alimentation requise.");
        }
        $date_alimentation = $_POST['dateAlimentation'];
        $idAliment = Flight::MesAnimauxModel()->getAlimentId($idAnimal);
        $stock = Flight::MesAnimauxModel()->verifierStockAliment($idAliment);
        if($stock == true){
            Flight::MesAnimauxModel()->updatequantite($idAliment);
            Flight::insertHistoriqueAlimentation($idAnimal, $date_alimentation);
        }
        Flight::redirect(constant('BASE_URL').'animaux/liste');
    }
}
