<?php

namespace app\models;

use Flight;
use PDO;


class ResetModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function reinitialiserDonnees() {
        // Vider la table elevage_Stock
        $stmt = $this->db->prepare("TRUNCATE TABLE elevage_Stock");
        $stmt->execute();
    
        // Vider la table elevage_Historique_Alimentation
        $stmt = $this->db->prepare("TRUNCATE TABLE elevage_Historique_Alimentation");
        $stmt->execute();
    
        // Remettre l'argent à 0 dans la table elevage_Argent
        $stmt = $this->db->prepare("UPDATE elevage_Argent SET argent = 0");
        $stmt->execute();
    
        // Mettre tous les animaux en vente (en_vente = 0) dans la table elevage_Animal
        $stmt = $this->db->prepare("UPDATE elevage_Animal SET en_vente = 0");
        $stmt->execute();
        
        return true; // Retourne true si tout s'est bien passé
    }
    
    
    
}
