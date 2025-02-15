<?php

namespace app\models;

use Flight;
use PDO;
use DateTime;


class MesAnimauxModel
{

    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllMesAnimaux()
    {
        $stmt = $this->db->prepare("
        SELECT 
            a.id_animal, 
            a.nom_animal, 
            a.image_animal, 
            a.poids_initial,
            a.auto_vente,
            a.date_mort,
            t.nom_type, 
            t.poids_min_vente, 
            t.poids_maximal, 
            t.prix_vente_kg
        FROM elevage_Animal a
        INNER JOIN elevage_Type_Animal t ON a.id_type_animal = t.id_type_animal
        WHERE a.en_vente = 1");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDateMort($id_animal, $date_mort) {
        $stmt = $this->db->prepare("UPDATE elevage_Animal SET date_mort = :date_mort WHERE id_animal = :id_animal");
        $success = $stmt->execute([
            ':id_animal' => $id_animal,
            ':date_mort' => $date_mort
        ]);
    
        return $success;
    }
    




}
