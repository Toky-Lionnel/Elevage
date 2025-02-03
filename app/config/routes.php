<?php

use app\controllers\LoginController;
use app\controllers\ModifTypeController;
use flight\Engine;
use flight\net\Router;
//use Flight;

$Login_Controller = new LoginController();
$Modif_Type_Controller = new ModifTypeController();

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


});

