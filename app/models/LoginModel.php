<?php

namespace app\models;

use Flight;
use PDO;


class LoginModel
{

    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function verifLoginAdmin($pseudo, $mdp)
    {

        $stmt = $this->db->prepare("SELECT * FROM admin WHERE pseudo = ? AND motdepasse = ?");
        $stmt->execute([$pseudo, $mdp]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            return 1;
        }

        return $result;
    }

    
    public function insererAdmin($pseudo, $motdepasse)
    {
        $stmt = $this->db->prepare("INSERT INTO admin (pseudo, motdepasse) VALUES (?, ?)");
        return $stmt->execute([$pseudo, $motdepasse]);
    }
}
