<?php

use app\controllers\LoginController;
use app\controllers\ModifTypeController;
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
use app\controllers\DepotController;
=======
use app\controllers\AnimauxController;
>>>>>>> Stashed changes
=======
use app\controllers\AnimauxController;
>>>>>>> Stashed changes
=======
use app\controllers\AnimauxController;
>>>>>>> Stashed changes
use flight\Engine;
use flight\net\Router;
//use Flight;

$Login_Controller = new LoginController();
$Modif_Type_Controller = new ModifTypeController();
$Depot_Controller = new DepotController();

$router->get('/', [$Login_Controller, 'loginUtilisateur']);
$router->post('/connexion', [$Login_Controller, 'verifUtilisateur']);
$router->get('/inscription', [$Login_Controller, 'inscription']);
$router->post('/inscription', [$Login_Controller, 'insertUtilisateur']);
$router->get('/admin/login', [$Login_Controller, 'loginAdmin']);
$router->post('/admin/login', [$Login_Controller, 'verifAdmin']);


$router->get('/accueil', [$Login_Controller, 'accueilAdmin']);
$router->get('/template', [$Login_Controller, 'prepaAjoutThe']);



$router->group('/type' , function () use ($router,$Modif_Type_Controller) {

	$router->get('/liste',[$Modif_Type_Controller,'listeTypeAnimal']);
    $router->get('/modifier/@id_type:[0-9]+',[$Modif_Type_Controller , 'prepaModifType']);
    $router->post('/modifier/@id_type:[0-9]+',[$Modif_Type_Controller , 'modificationType']);
});


<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
$router->get('/depot',[$Depot_Controller,'preDepot']);
$router->post('/depot',[$Depot_Controller,'updateArgent']);
=======
$Animaux_Controller = new AnimauxController();
$router ->get('/animaux/liste',[$Animaux_Controller,'listerAnimaux']);
>>>>>>> Stashed changes
=======
$Animaux_Controller = new AnimauxController();
$router ->get('/animaux/liste',[$Animaux_Controller,'listerAnimaux']);
>>>>>>> Stashed changes
=======
$Animaux_Controller = new AnimauxController();
$router ->get('/animaux/liste',[$Animaux_Controller,'listerAnimaux']);
>>>>>>> Stashed changes
