<?php

namespace app\models;

use Flight;
use PDO;


class VenteModel
{

    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function acheterAnimal($id_animal, $auto_vente) {
        // Mise à jour de l'animal avec en_vente et auto_vente
        $stmt = $this->db->prepare("UPDATE elevage_Animal SET en_vente = 1, auto_vente = :auto_vente WHERE id_animal = :id_animal");
        $result = $stmt->execute([':id_animal' => $id_animal, ':auto_vente' => $auto_vente]);
    
        if ($result) {
            return true; 
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("Erreur lors de l'achat de l'animal: " . $errorInfo[2]); 
            return false; 
        }
    }
    public function getAnimalsForSale(){
        $stmt = $this->db->prepare("
            SELECT 
                a.id_animal,
                a.nom_animal,
                a.poids_initial,
                a.image_animal,
                t.nom_type,
                t.poids_min_vente,
                t.poids_maximal,
                t.prix_vente_kg
            FROM elevage_Animal a
            JOIN elevage_Type_Animal t ON a.id_type_animal = t.id_type_animal
            WHERE a.en_vente = 0
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAnimalsForSaleVendre() {
        $stmt = $this->db->prepare("
            SELECT * FROM elevage_Animal  WHERE date_mort IS NULL AND auto_vente = 1 AND en_vente = 1
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function calculerPoidsVente($id_animal, $date_vente) {
        $stmt = $this->db->prepare("
            SELECT a.poids_initial, al.gain 
            FROM elevage_Animal a
            JOIN elevage_Alimentation al ON a.id_type_animal = al.id_alimentation
            WHERE a.id_animal = :id_animal
        ");
        $stmt->execute([':id_animal' => $id_animal]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$animal) return false;
    
        $poids = $animal['poids_initial'];
        $gain = $animal['gain'];
        
        $jours = (strtotime($date_vente) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
    
        for ($i = 0; $i <= $jours; $i++) {
            $poids += ($poids * ($gain / 100));
        }
    
        return $poids;
    }
    
    public function calculerPrixVente($id_animal, $date_vente) {
        $poids_final = $this->calculerPoidsVente($id_animal, $date_vente);
    
        $stmt = $this->db->prepare("
            SELECT prix FROM elevage_Alimentation 
            WHERE id_alimentation = (
                SELECT id_type_animal FROM elevage_Animal WHERE id_animal = :id_animal
            )
        ");
        $stmt->execute([':id_animal' => $id_animal]);
        $prix_kilo = $stmt->fetchColumn();
    
        return $poids_final * $prix_kilo;
    }
    
    public function vendreAnimal($id_animal, $date_vente) {
        $prix_final = $this->calculerPrixVente($id_animal, $date_vente);
    
        $this->db->beginTransaction();
    
        $stmt = $this->db->prepare("UPDATE elevage_Animal SET en_vente = 1 WHERE id_animal = :id_animal");
        $stmt->execute([':id_animal' => $id_animal]);
    
        $stmt = $this->db->prepare("UPDATE elevage_Argent SET argent = argent + :prix");
        $stmt->execute([':prix' => $prix_final]);
    
        $stmt = $this->db->prepare("UPDATE elevage_Stock SET quantite = quantite - 1 WHERE id_stock = (SELECT id_alimentation FROM elevage_Animal WHERE id_animal = :id_animal)");
        $stmt->execute([':id_animal' => $id_animal]);
    
        $this->db->commit();
    
        return true;
    }
    
    
    
    

}
