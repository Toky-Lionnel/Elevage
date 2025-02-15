<?php 

namespace app\controllers;

use app\models\ModifTypeModel;
use Flight;

class ModifTypeController {

    public function __construct() {

	}

    public function listeTypeAnimal () {

        $allType = Flight::ModifTypeModel()->getAllTypeAnimal();
        $listeData = ['allType' => $allType];
        Flight::render('liste_type', $listeData, 'contenu');
        Flight::render('template_the');

    }

    public function listeAlimentation () {

        $allType = Flight::ModifTypeModel()->getAllAlimentation();
        $listeData = ['allAlim' => $allType];
        Flight::render('liste_alimentation', $listeData, 'contenu');
        Flight::render('template_the');

    }


    public function prepaModifAlim ($id) {
        $type = Flight::ModifTypeModel()->getAlimentationById($id);
        $listeData = ['alimentation' => $type];
        Flight::render('modif_alim', $listeData, 'contenu');
        Flight::render('template_the');
    }


    public function ModifAlim ($id) {
        $data = Flight::request()->data;
        $gain = $data->gain;

        Flight::ModifTypeModel()->modifierGainAlimentation($id,$gain);
        Flight::redirect(constant('BASE_URL').'alimentation/liste');
    }

    

    public function prepaModifType ($id) {

        $type = Flight::ModifTypeModel()->getTypeById($id);
        $allAlimentation = Flight::ModifTypeModel()->getAllAlimentation();

        $listeData = ['allAlim' => $allAlimentation, 'allType' => $type];

        Flight::render('modif_type', $listeData, 'contenu');

        Flight::render('template_the');
    }


    public function modificationType ($id) {

        $data = Flight::request()->data;

        $nom = $data->nom;
        $poids_min = $data->poids_min;
        $prix = $data->prix_vente;
        $poids_max = $data->poids_max;
        $nb_jour = $data->nb_jour;
        $perte = $data->perte_poids;
        $alim = $data->alimentation;
        $quota = $data->quota;


        Flight::ModifTypeModel()->modifierTypeAnimal($id,$nom, $poids_min, $poids_max,$prix,$nb_jour,$perte,$alim,$quota);
        Flight::redirect(constant('BASE_URL').'type/liste');
    }

    



} 


?>