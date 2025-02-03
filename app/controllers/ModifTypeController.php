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

} 


?>