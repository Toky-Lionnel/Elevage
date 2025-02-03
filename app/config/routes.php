<?php

use app\controllers\LoginController;
use app\controllers\ModifTypeController;
use app\controllers\DepotController;
use app\controllers\VenteController;
use app\controllers\AnimauxController;

use flight\Engine;
use flight\net\Router;
//use Flight;

$Login_Controller = new LoginController();
$Modif_Type_Controller = new ModifTypeController();
$Depot_Controller = new DepotController();
$Vente_Controller = new VenteController();
$Animaux_Controller = new AnimauxController();

$router->get('/', [$Login_Controller, 'loginUtilisateur']);
$router->post('/connexion', [$Login_Controller, 'verifUtilisateur']);
$router->get('/inscription', [$Login_Controller, 'inscription']);
$router->post('/inscription', [$Login_Controller, 'insertUtilisateur']);
$router->get('/admin/login', [$Login_Controller, 'loginAdmin']);
$router->post('/admin/login', [$Login_Controller, 'verifAdmin']);

$router->get('/accueil', [$Login_Controller, 'accueilAdmin']);
$router->get('/template', [$Login_Controller, 'prepaAjoutThe']);

$router->group('/type' , function () use ($router, $Modif_Type_Controller) {
    $router->get('/liste', [$Modif_Type_Controller, 'listeTypeAnimal']);
    $router->get('/modifier/@id_type:[0-9]+', [$Modif_Type_Controller, 'prepaModifType']);
    $router->post('/modifier/@id_type:[0-9]+', [$Modif_Type_Controller, 'modificationType']);
});

$router->get('/depot', [$Depot_Controller, 'preDepot']);
$router->post('/depot', [$Depot_Controller, 'updateArgent']);

$router->get('/depot',[$Depot_Controller,'preDepot']);
$router->post('/depot',[$Depot_Controller,'updateArgent']);

$router->get('/animaux/liste/vente',[$Vente_Controller,'listAnimalsForSale']);
$router->get('/animaux/liste', [$Animaux_Controller, 'listerAnimaux']);
<<<<<<< HEAD

$router->get('/animaux/achat/@id', [$Vente_Controller,'acheterAnimal']);
=======
>>>>>>> 9bdf6c65a956f95f4df82a0cf2f99712c2bc677b
