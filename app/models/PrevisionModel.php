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
        $stmt = $this->db->prepare("SELECT * FROM elevage_Animal An JOIN elevage_Type_Animal Ta ON An.id_type_animal = Ta.id_type_animal
          WHERE An.id_type_animal = ? AND en_vente = 1");
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

    public function alimenterAnimaux($date_debut, $date_fin)
    {
        $types_animaux = $this->getTypesAnimaux();
        $situation_animaux = [];
        $situation_stocks = [];
    
        foreach ($types_animaux as $type) {
            // Récupérer les infos de l'alimentation et du stock
            $stock_info = $this->getStockDisponible($type['id_alimentation']);
            $stock_disponible = $stock_info['quantite'];
            $stock_animaux = $stock_info['nom_type'];
            $stock_initial = $stock_disponible;
            $stock_vidé = null;
            $nom_aliment = $stock_info['nom_aliment'];
            $gain = $stock_info['gain'];
            $jours_max_sans_manger = $type['nb_jour_sans_manger'];
            $perte_poids = $type['perte_poids'];
    
            $animaux = $this->getAnimauxParType($type['id_type_animal']);
            $nb_animaux_nourris = 0; // Nouveau compteur pour les animaux nourris
    
            // Récupérer la dernière date d’alimentation de chaque animal
            $dernieres_dates = $this->getDernierHistoriqueParAnimal();
            $dates_animaux = [];
            foreach ($dernieres_dates as $historique) {
                $dates_animaux[$historique['id_animal']] = $historique['derniere_date'];
            }
    
            // Parcourir les jours de la simulation
            for ($jour = strtotime($date_debut); $jour <= strtotime($date_fin); $jour += 86400) {
                $date_actuelle = date('Y-m-d', $jour);
    
                foreach ($animaux as &$animal) {
                    $dernier_repas = $dates_animaux[$animal['id_animal']] ?? $date_debut;
                    $jours_sans_manger = (strtotime($date_actuelle) - strtotime($dernier_repas)) / 86400;
    
                    if ($jours_sans_manger > $jours_max_sans_manger) {
                        $statut = "Mort";
                        continue; // Ne plus modifier son poids
                    } else {
                        $statut = "Vivant";
                    }
    
                    if ($stock_disponible > 0) {
                        // Nourrir l’animal s’il reste du stock
                        $animal['poids_initial'] += $gain;
                        $stock_disponible -= 1;
                        $dates_animaux[$animal['id_animal']] = $date_actuelle;
                        
                        // Incrémenter le compteur des animaux nourris
                        if (!isset($animal['déjà_nourri'])) {
                            $nb_animaux_nourris++;
                            $animal['déjà_nourri'] = true; // Marquer qu’il a été nourri au moins une fois
                        }
                    } else {
                        // Appliquer la perte de poids en pourcentage
                        $animal['poids_initial'] -= ($animal['poids_initial'] * ($perte_poids / 100));
    
                        if ($stock_vidé === null) {
                            $stock_vidé = $date_actuelle;
                        }
                    }
                }
            }
    
            // Ajouter la situation finale des animaux
            foreach ($animaux as $animal) {
                $dernier_repas = $dates_animaux[$animal['id_animal']] ?? "Jamais nourri";
                $jours_sans_manger = (strtotime($date_fin) - strtotime($dernier_repas)) / 86400;
                $statut = ($jours_sans_manger > $jours_max_sans_manger) ? "Mort" : "Vivant";
    
                $situation_animaux[] = [
                    'id_animal' => $animal['id_animal'],
                    'animal' => $animal['nom_animal'],
                    'image' => $animal['image_animal'],
                    'poids_final' => $this->verifPoidsMax($animal['poids_initial'], $animal['poids_maximal']),
                    'poids_max' => $animal['poids_maximal'],
                    'type_animal' => $type['nom_type'],
                    'dernier_repas' => $dernier_repas,
                    'nombre_sans_manger' => $jours_sans_manger,
                    'statut' => $statut
                ];
            }
    
            // Ajouter la situation du stock avec le nombre d'animaux nourris
            $situation_stocks[] = [
                'nom_aliment' => $nom_aliment,
                'type_animal' => $stock_animaux,
                'stock_initial' => $stock_initial,
                'stock_final' => $stock_disponible,
                'stock_vidé_le' => $stock_vidé ?? "Non vidé",
                'animaux_nourris' => $nb_animaux_nourris // Nombre d'animaux nourris avec ce stock
            ];
        }
    
        return [
            'animaux' => $situation_animaux,
            'stocks' => $situation_stocks
        ];
    }
        




    public function verifPoidsMax($poids_actuel, $poids_max)
    {
        if ($poids_max < $poids_actuel) {
            return $poids_max;
        }
        return $poids_actuel;
    }


}
