<?php 

namespace app\controllers;

use app\models\PrevisionModel;
use Flight;

class PrevisionController {

    public function __construct() {

	}


    public function prepaPrevision () {

        $date_debut = '2025-02-03';
        $date_fin = '2025-02-18';

        $result = Flight::PrevisionModel()->alimenterAnimaux($date_debut,$date_fin);

        print_r($result);

    }

    }
?>