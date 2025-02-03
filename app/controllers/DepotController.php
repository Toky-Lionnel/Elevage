<?php

namespace app\controllers;

use app\models\DepotModel;
use Flight;

class DepotController
{

    public function __construct() {}


    public function preDepot()
    {
        $argent = Flight::DepotModel()->getArgent();
        $data = ['page' => 'depot','argent' => $argent ];
        Flight::render('template_the', $data);
    }



    public function updateArgent()
    {
        $data = Flight::request()->data;
        $argent = $data->argent;

        Flight::DepotModel()->updateArgent($argent);

        Flight::redirect(constant('BASE_URL') . 'type/liste');
    }
}
