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
            Flight::MesAnimauxModel()->insertHistoriqueAlimentation($idAnimal, $date_alimentation);
        }
        Flight::redirect(constant('BASE_URL').'animaux/liste');
    }

    public function vendreAnimal($idAnimal){
        if (!isset($_POST['dateFin'])) {
            // Gérer l'erreur si la date n'est pas envoyée
            die("Date d'alimentation requise.");
        }
        $date_fin = $_POST['dateFin'];
        $poid = Flight::MesAnimauxModel()->calculerPoidsAnimal($idAnimal, $date_fin);
        Flight::MesAnimauxModel()->updatePoidsAnimal($idAnimal, $poid);
        $prix = Flight::MesAnimauxModel()->Prix($idAnimal, $poid);
        Flight::MesAnimauxModel()->updateDepot($prix);
        Flight::MesAnimauxModel()->mettreEnVente($idAnimal);
        Flight::redirect(constant('BASE_URL').'animaux/liste');
    }

}
