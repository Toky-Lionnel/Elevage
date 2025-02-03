<?php

namespace app\models;

use Flight;
use PDO;


class PrevisionModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getDernierHistoriqueParAnimal()
    {
        $stmt = $this->db->prepare("
        SELECT ha.* 
        FROM elevage_Historique_Alimentaion ha
        INNER JOIN (
            SELECT id_animal, MAX(date_alimentation) AS derniere_date
            FROM elevage_Historique_Alimentaion
            GROUP BY id_animal
        ) dernier ON ha.id_animal = dernier.id_animal AND ha.date_alimentation = dernier.derniere_date
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
