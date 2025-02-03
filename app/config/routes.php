<?php

use app\controllers\LoginController;
use flight\Engine;
use flight\net\Router;
//use Flight;

$Login_Controller = new LoginController();


$router->get('/', [$Login_Controller, 'loginUtilisateur']);
$router->post('/connexion', [$Login_Controller, 'verifUtilisateur']);
$router->get('/inscription', [$Login_Controller, 'inscription']);
$router->post('/inscription', [$Login_Controller, 'insertUtilisateur']);
$router->get('/admin/login', [$Login_Controller, 'loginAdmin']);
$router->post('/admin/login', [$Login_Controller, 'verifAdmin']);
