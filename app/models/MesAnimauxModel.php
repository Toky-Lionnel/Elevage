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
            SELECT id_alimentation 
            FROM elevage_Type_Animal 
            WHERE id_type_animal = ?
        ");
        $stmt->execute([$id_type_animal]);
        return $stmt->fetchColumn(); // Retourne directement l'ID de l'alimentation
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

    public function updatequantite ($id_alimentation){
        $stmt = $this->db->prepare("
            UPDATE elevage_Stock
            SET quantite = quantite - 1
            WHERE id_alimentation = ?
        ");
        $stmt->execute([$id_alimentation]);
    }

    public function insertHistoriqueAlimentation($id_animal, $date_alimentation) {
        // Préparation de la requête pour récupérer le gain de l'aliment associé à l'animal
        $stmt = $this->db->prepare("
            SELECT a.gain, an.poids_initial
            FROM elevage_Animal an
            JOIN elevage_Type_Animal ta ON an.id_type_animal = ta.id_type_animal
            JOIN elevage_Alimentation a ON ta.id_alimentation = a.id_alimentation
            WHERE an.id_animal = ?
        ");
        $stmt->execute([$id_animal]);
    
        // Récupération des résultats
        $animalData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($animalData) {
            // Calcul du nouveau poids
            $gain = $animalData['gain'];
            $poids_initial = $animalData['poids_initial'];
            $nouveau_poids = $poids_initial * (1 + ($gain / 100));
    
            // Préparation de la requête d'insertion dans la table elevage_Historique_Alimentation
            $stmt = $this->db->prepare("
                INSERT INTO elevage_Historique_Alimentation (id_animal, date_alimentation, poids)
                VALUES (?, ?, ?)
            ");
            
            // Exécution de l'insertion avec les paramètres
            $stmt->execute([$id_animal, $date_alimentation, $nouveau_poids]);
        }
    }

    
    
    

}
