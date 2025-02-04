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
        $stmt = $this->db->prepare("SELECT * FROM elevage_Type_Animal TA JOIN elevage_Alimentation Al ON 
        TA.id_alimentation = Al.id_alimentation");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ity zavatra ity mila ampiana ilay resaka date_mort
    public function getAnimauxParType($id_type_animal)
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Animal An JOIN elevage_Type_Animal Ta ON An.id_type_animal = Ta.id_type_animal 
        JOIN elevage_Alimentation Al ON Ta.id_alimentation=Al.id_alimentation WHERE An.id_type_animal = ? AND en_vente = 1");
        $stmt->execute([$id_type_animal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStockDisponible($id_alimentation)
    {
        $stmt = $this->db->prepare("
        SELECT s.quantite, a.nom_aliment, a.gain, Ta.nom_type
        FROM elevage_Stock s
        JOIN elevage_Alimentation a ON s.id_alimentation = a.id_alimentation JOIN elevage_Type_Animal Ta ON a.id_alimentation = Ta.id_alimentation
        WHERE s.id_alimentation = ?
    ");
        $stmt->execute([$id_alimentation]);

        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la quantité, le nom de l'aliment et le gain
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


    public function verifPoidsMax($poids_actuel, $poids_max)
    {
        if ($poids_max < $poids_actuel) {
            return $poids_max;
        }
        return $poids_actuel;
    }



    public function alimenterAnimaux($date_debut, $date_fin)
    {
        $types_animaux = $this->getTypesAnimaux();
        $situation_animaux = [];
        $situation_stocks = [];

        foreach ($types_animaux as $type) {

            $stock_info = $this->getStockInfo($type['id_alimentation']);
            $stock_disponible = $stock_info['quantite'];
            $stock_initial = $stock_disponible;
            $stock_vidé = null;
            $nom_aliment = $stock_info['nom_aliment'];
            $gain = $stock_info['gain'];
            $jours_max_sans_manger = $type['nb_jour_sans_manger'];
            $perte_poids = $type['perte_poids'];

            $animaux = $this->getAnimauxParType($type['id_type_animal']);
            $dates_animaux = $this->getDernieresDatesAlimentation($type['id_type_animal']);

            $this->simulerAlimentation($animaux, $dates_animaux, $stock_disponible, $date_debut, $date_fin, $gain, $perte_poids, $jours_max_sans_manger, $stock_vidé);

            $situation_animaux = array_merge($situation_animaux, $this->genererSituationAnimaux($animaux, $dates_animaux, $type, $date_fin, $jours_max_sans_manger));
            $situation_stocks[] = $this->genererSituationStock($nom_aliment, $stock_initial, $stock_disponible, $stock_vidé);
        }

        return [
            'animaux' => $situation_animaux,
            'stocks' => $situation_stocks
        ];
    }


    private function getStockInfo($id_alimentation)
    {
        $stmt = $this->db->prepare("SELECT nom_aliment, gain, quantite FROM elevage_Alimentation 
                                    JOIN elevage_Stock ON elevage_Alimentation.id_alimentation = elevage_Stock.id_alimentation
                                    WHERE elevage_Alimentation.id_alimentation = ?");
        $stmt->execute([$id_alimentation]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    private function getDernieresDatesAlimentation($type)
    {
        $animaux = $this->getAnimauxParType($type);
        $dates_animaux = [];

        foreach ($animaux as $animal) {
            $dates_animaux[$animal['id_animal']] = date('Y-m-d');
        }

        return $dates_animaux;
    }

    private function simulerAlimentation(&$animaux, &$dates_animaux, &$stock_disponible, $date_debut, $date_fin, $gain, $perte_poids, $jours_max_sans_manger, &$stock_vidé)
    {
        for ($jour = strtotime($date_debut); $jour <= strtotime($date_fin); $jour += 86400) {
            $date_actuelle = date('Y-m-d', $jour);

            usort($animaux, function ($a, $b) {
                return ($a['poids_initial'] < $a['poids_min_vente']) - ($b['poids_initial'] < $b['poids_min_vente']);
            });

            foreach ($animaux as &$animal) {
                // Vérifier si l'animal est déjà mort
                if (isset($animal['statut']) && $animal['statut'] === "Mort") {
                    continue;
                }

                $dernier_repas = $dates_animaux[$animal['id_animal']] ?? $date_debut;
                $jours_sans_manger = (strtotime($date_actuelle) - strtotime($dernier_repas)) / 86400;

                // Vérifier si l'animal est mort à cause du manque de nourriture
                if ($jours_sans_manger > $jours_max_sans_manger) {
                    $animal['statut'] = "Mort le " . $date_actuelle;
                    continue;
                } else {
                    $animal['statut'] = "Vivant";
                }

                // Nourrir l'animal seulement si le stock est suffisant
                if ($stock_disponible >= $animal['quota']) {
                    if ($animal['poids_initial'] < $animal['poids_maximal']) {
                        $nouveau_poids = $animal['poids_initial'] + ($animal['poids_initial'] * ($gain / 100));
                        $animal['poids_initial'] = min($nouveau_poids, $animal['poids_maximal']);
                    }

                    $stock_disponible -= $animal['quota'];
                    $dates_animaux[$animal['id_animal']] = $date_actuelle;
                } else {
                    // Si le stock est insuffisant, l'animal perd du poids
                    $animal['poids_initial'] -= ($animal['poids_initial'] * ($perte_poids / 100));

                    // Marquer la date à laquelle le stock a été vidé
                    if ($stock_vidé === null) {
                        $stock_vidé = $date_actuelle;
                    }
                }
            }
        }
    }


    private function genererSituationAnimaux($animaux, $dates_animaux, $type, $date_fin, $jours_max_sans_manger)
    {
        $result = [];

        foreach ($animaux as $animal) {
            $dernier_repas = $dates_animaux[$animal['id_animal']] ?? "Jamais nourri";
            $jours_sans_manger = (strtotime($date_fin) - strtotime($dernier_repas)) / 86400;

            $statut = $animal['statut'];

            $result[] = [
                'id_animal' => $animal['id_animal'],
                'animal' => $animal['nom_animal'],
                'image' => $animal['image_animal'],
                'auto_vente' => $animal['auto_vente'],
                'en_vente' => $animal['en_vente'],
                'date_vente' => $animal['date_vente'] ?? null, // Display the sale date
                'poids_final' => $this->verifPoidsMax($animal['poids_initial'], $animal['poids_maximal']),
                'poids_max' => $animal['poids_maximal'],
                'type_animal' => $type['nom_type'],
                'quota' => $type['quota'],
                'dernier_repas' => $dernier_repas,
                'nombre_sans_manger' => $jours_sans_manger,
                'statut' => $statut,
            ];
        }

        return $result;
    }

    private function genererSituationStock($nom_aliment, $stock_initial, $stock_final, $stock_vidé)
    {
        return [
            'nom_aliment' => $nom_aliment,
            'stock_initial' => $stock_initial,
            'stock_final' => $stock_final,
            'stock_vidé_le' => $stock_vidé ?? "Non vidé"
        ];
    }
}
