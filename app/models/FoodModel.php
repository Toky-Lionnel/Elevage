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
        // Récupérer le prix de l'aliment
        $stmt = $this->db->prepare("SELECT prix FROM elevage_Alimentation WHERE id_alimentation = :id_alimentation");
        $stmt->execute([':id_alimentation' => $id_alimentation]);
        $aliment = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($aliment) {
            $totalCost = $aliment['prix'] * $quantite;
    
            // Récupérer l'argent disponible
            $stmt = $this->db->prepare("SELECT argent FROM elevage_Argent LIMIT 1");
            $stmt->execute();
            $argent = $stmt->fetchColumn();
    
            if ($argent >= $totalCost) {
                // Déduire l'argent après achat
                $newArgent = $argent - $totalCost;
                $stmt = $this->db->prepare("UPDATE elevage_Argent SET argent = :argent");
                $stmt->execute([':argent' => $newArgent]);
    
                // Ajouter l'aliment au stock (ou mettre à jour la quantité existante)
                $stmt = $this->db->prepare("
                    INSERT INTO elevage_Stock (id_alimentation, quantite)
                    VALUES (:id_alimentation, :quantite)
                    ON DUPLICATE KEY UPDATE quantite = quantite + VALUES(quantite)
                ");
                return $stmt->execute([':id_alimentation' => $id_alimentation, ':quantite' => $quantite]);
            } else {
                return false; // Pas assez d'argent
            }
        }
    
        return false; // Aliment non trouvé
    }
    



}


?>