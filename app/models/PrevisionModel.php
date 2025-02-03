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

    public function getTypesAnimaux() {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Type_Animal");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimauxParType($id_type_animal) {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Animal WHERE id_type_animal = ?");
        $stmt->execute([$id_type_animal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStockDisponible($id_alimentation) {
        $stmt = $this->db->prepare("SELECT quantite FROM elevage_Stock WHERE id_alimentation = ?");
        $stmt->execute([$id_alimentation]);
        return $stmt->fetchColumn();
    }

    public function getDernierHistoriqueParAnimal() {
        $stmt = $this->db->prepare("SELECT ha.id_animal, MAX(ha.date_alimentation) AS derniere_date FROM elevage_Historique_Alimentaion ha GROUP BY ha.id_animal");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alimenterAnimaux($date_debut, $date_fin) {
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
                $dates_animaux[$historique['id_animal']] = $historique['date_alimentation'];
            }
    
            foreach ($animaux as &$animal) {
                $date_actuelle = isset($dates_animaux[$animal['id_animal']]) ? $dates_animaux[$animal['id_animal']] : $date_debut;
                $nb_jours = (strtotime($date_fin) - strtotime($date_actuelle)) / (60 * 60 * 24);
    
                for ($jour = 0; $jour < $nb_jours; $jour++) {
                    if ($stock_disponible > 0) {
                        // Vérifier qu’il reste du stock avant de nourrir l’animal
                        if ($stock_disponible >= 1) {
                            $stmt = $this->db->prepare("SELECT gain FROM elevage_Alimentation WHERE id_alimentation = ?");
                            $stmt->execute([$type['id_alimentation']]);
                            $gain = $stmt->fetchColumn();
    
                            $animal['poids_initial'] += $gain;
                            $stock_disponible -= 1;
    
                            // Mettre à jour la dernière date d’alimentation de cet animal
                            $dates_animaux[$animal['id_animal']] = date('Y-m-d', strtotime($date_actuelle) + ($jour * 86400));
                        }
                    } else {
                        // Si le stock est insuffisant, appliquer la perte de poids
                        $animal['poids_initial'] -= 0.5;
    
                        // Enregistrer la première date où le stock est vidé
                        if ($stock_vidé === null) {
                            $stock_vidé = date('Y-m-d', strtotime($date_actuelle) + ($jour * 86400));

                        }
                    }
                }
            }
    
            // Ajouter la situation des animaux
            foreach ($animaux as $animal) {
                $situation_animaux[] = [
                    'animal' => $animal['nom_animal'],
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
    
}
