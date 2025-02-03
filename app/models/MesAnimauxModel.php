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

    public function ListerAnimaux() {
        $stmt = $this->db->prepare("SELECT id_animal, id_type_animal, poids_initial, image_animal, nom_animal FROM elevage_Animal WHERE en_vente = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}