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

    public function getAlimentId($id_type_animal) {
        $stmt = $this->db->prepare("
            SELECT t.id_alimentation 
            FROM elevage_Type_Animal t
            WHERE t.id_type_animal = ?
        ");
        $stmt->execute([$id_type_animal]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne l'ID de l'aliment
    }

    public function verifierStockAliment($id_alimentation) {
        $stmt = $this->db->prepare("
            SELECT quantite 
            FROM elevage_Stock
            WHERE id_alimentation = ?
        ");
        $stmt->execute([$id_alimentation]);
    
        $quantite_stock = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère la quantité en stock
    
        // Vérification si la quantité en stock est suffisante
        return ($quantite_stock !== false && $quantite_stock >= 1);
    }

    public function updatequantité ($id_alimentation){
        $stmt = $this->db->prepare("
            UPDATE elevage_Stock
            SET quantite = quantite - 1
            WHERE id_alimentation = ?
        ");
        $stmt->execute([$id_alimentation]);
    }

    

}
