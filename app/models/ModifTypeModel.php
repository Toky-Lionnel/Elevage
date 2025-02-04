<?php

namespace app\models;

use Flight;
use PDO;


class ModifTypeModel
{

    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function getAllTypeAnimal()
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Type_Animal tA JOIN 
        elevage_Alimentation Al ON tA.id_alimentation = Al.id_alimentation ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTypeById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Type_Animal tA JOIN 
        elevage_Alimentation Al ON tA.id_alimentation = Al.id_alimentation WHERE id_type_animal = ? ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAlimentation()
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Alimentation");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getAlimentationbyId($id_alimentation)
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Alimentation WHERE id_alimentation = ? ");
        $stmt->execute([$id_alimentation]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function modifierGainAlimentation($id_alimentation, $nouveau_gain) 
    {
        $stmt = $this->db->prepare("UPDATE elevage_Alimentation 
            SET gain = ? WHERE id_alimentation = ?");        
        return $stmt->execute([$nouveau_gain, $id_alimentation]);
    }
    

    public function modifierTypeAnimal($id_type_animal, $nom_type, $poids_min_vente, $poids_maximal, $prix_vente_kg, $nb_jour_sans_manger, $perte_poids, $id_alimentation,$quota)
    {
        $stmt = $this->db->prepare("UPDATE elevage_Type_Animal 
        SET nom_type = ?, poids_min_vente = ?, poids_maximal = ?, prix_vente_kg = ?, nb_jour_sans_manger = ?, perte_poids = ?, id_alimentation = ?, quota = ?
        WHERE id_type_animal = ?");
        $stmt->execute([$nom_type, $poids_min_vente, $poids_maximal, $prix_vente_kg, $nb_jour_sans_manger, $perte_poids, $id_alimentation, $quota,$id_type_animal]);
    }
}
