<?php 

namespace app\controllers;

use app\models\LoginModel;
use Flight;

class LoginController {

    public function __construct() {

	}


    public function loginAdmin() {
        $data = ['page' => 'login_admin', 'nom' => 'Connexion Admin'];
        Flight::render('template_login',$data);
    }

    public function loginUtilisateur () {
        $data = ['page' => 'login_utilisateur', 'nom' => 'Connexion'];
        Flight::render('template_login',$data);
    }


    public function inscription () {
        $data = ['page' => 'inscription', 'nom' => 'Inscription'];
        Flight::render('template_login',$data);
    }


    public function verifAdmin () {
        $data = Flight::request()->data;

        $pseudo = $data->username;
        $mdp = $data->password;

        $result = Flight::LoginModel()->verifLoginAdmin($pseudo,$mdp);
        
        if (!empty($result)) {
            Flight::redirect(constant('BASE_URL').'admin/accueil');
        } else {
            session_start();
            $_SESSION['connexion'] = "Login Incorrect ou Mot de passe erroné pour l'Admin";
            $_SESSION['type'] = "error";
            Flight::redirect(constant('BASE_URL').'admin/login');
        }
    }


    public function verifUtilisateur () {
        $data = Flight::request()->data;

        $pseudo = $data->username;
        $mdp = $data->password;

        $result = Flight::LoginModel()->verifLoginAdmin($pseudo,$mdp);
        
        if (!empty($result)) {
            Flight::redirect(constant('BASE_URL').'admin/accueil');
        } else {
            session_start();
            $_SESSION['connexion'] = "Login Incorrect ou Mot de passe erroné";
            $_SESSION['type'] = "danger";
            Flight::redirect(constant('BASE_URL'));
        }
    }

    
    public function insertUtilisateur () 
    {
        $data = Flight::request()->data;

        $pseudo = $data->username;
        $mdp = $data->password;

        Flight::LoginModel()->insererAdmin($pseudo,$mdp);
        session_start();
        $_SESSION['connexion'] = "Inscription reussi, veuillez vous connecter";
        $_SESSION['type'] = "success";
        Flight::redirect(constant('BASE_URL'));
    }










} 



?>