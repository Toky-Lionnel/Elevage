<?php

use app\controllers\LoginController;
use app\controllers\ModifTypeController;
use app\controllers\DepotController;
use app\controllers\VenteController;
use app\controllers\MesAnimauxController;
use app\controllers\FoodController;
use app\controllers\PrevisionController;
use app\controllers\StockController;
use app\controllers\ResetController;
use flight\Engine;
use flight\net\Router;
//use Flight;

$Login_Controller = new LoginController();
$Modif_Type_Controller = new ModifTypeController();
$Depot_Controller = new DepotController();
$Vente_Controller = new VenteController();
$Animaux_Controller = new MesAnimauxController();
$Food_Controller = new FoodController();
$Prevision_Controller = new PrevisionController();
$Stock_Controller = new StockController();
$Reset_Controller = new ResetController();


$router->get('/', function() {
    Flight::redirect('animaux/liste/vente');
});


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

$router->get('/alimentation/liste', [$Modif_Type_Controller,'listeAlimentation']);
$router->get('/alimentation/modifier/@id_type:[0-9]+', [$Modif_Type_Controller,'prepaModifAlim']);
$router->post('/alimentation/modifier/@id_type:[0-9]+', [$Modif_Type_Controller,'ModifAlim']);


$router->get('/depot', [$Depot_Controller, 'preDepot']);
$router->post('/depot', [$Depot_Controller, 'updateArgent']);

$router->get('/depot',[$Depot_Controller,'preDepot']);
$router->post('/depot',[$Depot_Controller,'updateArgent']);

$router->get('/animaux/liste/vente',[$Vente_Controller,'listAnimalsForSale']);

$router->post('/animaux/achat/@id', [$Vente_Controller, 'acheterAnimal']);



$router->get('/liste/alimentation', [$Food_Controller, 'listAliments']);


$router->get('/prevision',[$Prevision_Controller,'prePrevision']);
$router->post('/prevision',[$Prevision_Controller,'prevision']);

$router->get('/achat/alimentation', [$Food_Controller, 'acheterAliment']);

$router->get('/liste/stock', [$Stock_Controller, 'afficherStock']);

$router->get('/reset', [$Reset_Controller, 'reset']);

$router->get('/liste/mesanimaux', [$Animaux_Controller, 'afficherMesAnimaux']);
$router->post('/ajouter_date_mort', [$Animaux_Controller,'ajouterDateMort']);
$router->post('/liste/vendre/mesanimaux',[$Vente_Controller,'listAnimalsForSaleVendre'] );
$router->post('/vente/@id', [$Vente_Controller, 'vendreAnimal']);