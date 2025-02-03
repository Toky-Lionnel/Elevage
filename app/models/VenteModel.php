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

    public function acheterAnimal($id_animal) {
        $stmt = $this->db->prepare("UPDATE elevage_Animal SET en_vente = 1 WHERE id_animal = :id_animal");
        $result = $stmt->execute([':id_animal' => $id_animal]);
        
        if ($result) {
            return true; 
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("Erreur lors de l'achat de l'animal: " . $errorInfo[2]); 
            return false; 
        }
    }
    
    

}
