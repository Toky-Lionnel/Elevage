<?php

namespace app\models;

use Flight;
use PDO;


class PrevisionModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function getTypesAnimaux()
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Type_Animal");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimauxParType($id_type_animal)
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Animal WHERE id_type_animal = ? AND en_vente = 1");
        $stmt->execute([$id_type_animal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStockDisponible($id_alimentation)
    {
        $stmt = $this->db->prepare("SELECT quantite FROM elevage_Stock WHERE id_alimentation = ?");
        $stmt->execute([$id_alimentation]);
        return $stmt->fetchColumn();
    }

    public function getDernierHistoriqueParAnimal()
    {
        $stmt = $this->db->prepare("
        SELECT ha.id_animal, MAX(ha.date_alimentation) AS derniere_date 
        FROM elevage_Historique_Alimentation ha
        INNER JOIN elevage_Animal a ON ha.id_animal = a.id_animal
        WHERE a.en_vente = 1
        GROUP BY ha.id_animal
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function alimenterAnimaux($date_debut, $date_fin)
    {
        $types_animaux = $this->getTypesAnimaux();
        $situation_animaux = [];
    
        foreach ($types_animaux as $type) {
            $animaux = $this->getAnimauxParType($type['id_type_animal']);
            $stock_disponible = $this->getStockDisponible($type['id_alimentation']);
            $stock_initial = $stock_disponible;
            $stock_vidé = null;
    
            // Récupérer la dernière date d’alimentation de chaque animal
            $dernieres_dates = $this->getDernierHistoriqueParAnimal();
            $dates_animaux = [];
            foreach ($dernieres_dates as $historique) {
                $dates_animaux[$historique['id_animal']] = $historique['derniere_date'];
            }
    
            // Récupérer le gain de poids par aliment
            $stmt = $this->db->prepare("SELECT gain FROM elevage_Alimentation WHERE id_alimentation = ?");
            $stmt->execute([$type['id_alimentation']]);
            $gain = $stmt->fetchColumn();
    
            // Parcourir les jours de la simulation
            for ($jour = strtotime($date_debut); $jour <= strtotime($date_fin); $jour += 86400) {
                $date_actuelle = date('Y-m-d', $jour);
    
                foreach ($animaux as &$animal) {
                    if ($stock_disponible > 0) {
                        // Nourrir l’animal s’il reste du stock
                        $animal['poids_initial'] += $gain;
                        $stock_disponible -= 1;
                        $dates_animaux[$animal['id_animal']] = $date_actuelle;
                    } else {
                        // Si le stock est vide, appliquer la perte de poids
                        $animal['poids_initial'] -= 0.5;
    
                        // Enregistrer la première date où le stock est vidé
                        if ($stock_vidé === null) {
                            $stock_vidé = $date_actuelle;
                        }
                    }
                }
            }
    
            // Ajouter la situation finale des animaux
            foreach ($animaux as $animal) {
                $situation_animaux[] = [
                    'id_animal' => $animal['id_animal'],
                    'animal' => $animal['nom_animal'],
                    'image' => $animal['image_animal'],
                    'poids_final' => $animal['poids_initial'],
                    'type_animal' => $type['nom_type'],
                    'stock_initial' => $stock_initial,
                    'stock_final' => $stock_disponible,
                    'stock_vidé_le' => $stock_vidé,
                    'dernier_repas' => $dates_animaux[$animal['id_animal']] ?? "Jamais nourri"
                ];
            }
        }
        return $situation_animaux;
    }



    function getStatus ($poids_min,$poids_act) {

        if ($poids_min>=$poids_act){
            return false; // maty 
        }
        return true; // en vie

    }
    
}
