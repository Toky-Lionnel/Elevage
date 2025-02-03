<?php

namespace app\models;

use Flight;
use PDO;


class FoodModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllAliments()
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Alimentation");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function acheterAliment($id_alimentation, $quantite)
    {

        $stmt = $this->db->prepare("SELECT prix FROM elevage_Alimentation WHERE id_alimentation = :id_alimentation");
        $stmt->bindValue(':id_alimentation', $id_alimentation, PDO::PARAM_INT);
        $stmt->execute();
        $aliment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($aliment) {
            $totalCost = $aliment['prix'] * $quantite;


            $stmt = $this->db->prepare("SELECT argent FROM elevage_Argent LIMIT 1");
            $stmt->execute();
            $argent = $stmt->fetchColumn();

            if ($argent >= $totalCost) {

                $newArgent = $argent - $totalCost;
                $stmt = $this->db->prepare("UPDATE elevage_Argent SET argent = :argent");
                $stmt->bindValue(':argent', $newArgent, PDO::PARAM_DECIMAL);
                $stmt->execute();

                $stmt = $this->db->prepare("INSERT INTO elevage_Stock (id_alimentation, quantite) VALUES (:id_alimentation, :quantite) ON DUPLICATE KEY UPDATE quantite = quantite + :quantite");
                $stmt->bindValue(':id_alimentation', $id_alimentation, PDO::PARAM_INT);
                $stmt->bindValue(':quantite', $quantite, PDO::PARAM_INT);
                return $stmt->execute();
            } else {
                return false; // Pas assez d'argent
            }
        }

        return false; // Aliment non trouvé
    }



}


?>