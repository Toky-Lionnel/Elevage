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
        // Récupérer les informations de gain et poids initial
        $stmt = $this->db->prepare("
            SELECT a.gain, an.poids_initial
            FROM elevage_Animal an
            JOIN elevage_Type_Animal ta ON an.id_type_animal = ta.id_type_animal
            JOIN elevage_Alimentation a ON ta.id_alimentation = a.id_alimentation
            WHERE an.id_animal = ?
        ");
        $stmt->execute([$id_animal]);
        $animalData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
        $gain = $animalData['gain'];
        $poids_initial = $animalData['poids_initial'];
    
        // Récupérer le dernier poids enregistré dans l'historique
        $stmt = $this->db->prepare("
            SELECT poids FROM elevage_Historique_Alimentation
            WHERE id_animal = ?
            ORDER BY date_alimentation DESC
            LIMIT 1
        ");
        $stmt->execute([$id_animal]);
        $lastWeight = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Si l'animal a déjà été nourri, prendre le dernier poids enregistré, sinon poids_initial
        $poids_actuel = $lastWeight ? $lastWeight['poids'] : $poids_initial;
    
        // Calcul du nouveau poids
        $nouveau_poids = $poids_actuel + (($gain / 100) * $poids_actuel);
    
        // Insérer le nouveau poids dans l'historique
        $stmt = $this->db->prepare("
            INSERT INTO elevage_Historique_Alimentation (id_animal, date_alimentation, poids)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$id_animal, $date_alimentation, $nouveau_poids]);
    }
    
    

}
