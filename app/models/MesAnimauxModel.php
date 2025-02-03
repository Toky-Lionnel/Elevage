<?php

namespace app\models;

use Flight;
use PDO;


class MesAnimauxModel
{

    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function verifLoginAdmin()
    {

        $stmt = $this->db->prepare("SELECT * FROM elevage_Animal WHERE en_vente = 1");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

}