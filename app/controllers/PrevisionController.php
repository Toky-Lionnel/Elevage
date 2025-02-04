<?php

namespace app\controllers;

use app\models\PrevisionModel;
use Flight;

class PrevisionController
{

    public function __construct() {}


    public function prevision()
    {
        $data = Flight::request()->data;
        $date_fin = $data->date_prev;

        $date_debut = date('Y-m-d');

        if ($date_fin < $date_debut) {
            Flight::json("ERROR");
        } else {
            $result = Flight::PrevisionModel()->alimenterAnimaux($date_debut, $date_fin);
            Flight::json($result);
        }

        // $result = Flight::PrevisionModel()->alimenterAnimaux($date_debut, $date_fin);
        // print_r($result);

    }


    public function prePrevision()
    {
        $data = ['page' => 'prevision'];
        Flight::render('template_the', $data);
    }
}
