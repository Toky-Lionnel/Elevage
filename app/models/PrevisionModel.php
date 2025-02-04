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
            $stock_info = $this->getStockDisponible($type['id_alimentation']);
            $stock_disponible = $stock_info['quantite'];
            $animaux = $this->getAnimauxParType($type['id_type_animal']);

            $resultat = $this->simulerAlimentation($animaux, $type, $stock_disponible, $date_debut, $date_fin);

            $situation_animaux = array_merge($situation_animaux, $resultat['animaux']);
            $situation_stocks[] = [
                'nom_aliment' => $stock_info['nom_aliment'],
                'type_animal' => $type['nom_type'],
                'stock_initial' => $stock_info['quantite'],
                'stock_final' => $resultat['stock_disponible'],
                'stock_vidé_le' => $resultat['stock_vidé'] ?? "Non vidé",
                'animaux_nourris' => $resultat['animaux_nourris']
            ];
        }

        return ['animaux' => $situation_animaux, 'stocks' => $situation_stocks];
    }

    private function simulerAlimentation($animaux, $type, &$stock_disponible, $date_debut, $date_fin)
    {
        $dates_animaux = $this->initialiserDatesRepas($animaux, $date_debut);
        $nb_animaux_nourris = 0;
        $stock_vidé = null;

        for ($jour = strtotime($date_debut); $jour <= strtotime($date_fin); $jour += 86400) {
            $date_actuelle = date('Y-m-d', $jour);
            usort($animaux, [$this, 'trierAnimauxParProximiteVente']);

            foreach ($animaux as &$animal) {
                $this->traiterAnimal($animal, $type, $dates_animaux, $stock_disponible, $date_actuelle, $nb_animaux_nourris, $stock_vidé);
            }
            unset($animal);
        }

        return [
            'animaux' => $this->genererSituationAnimaux($animaux, $type, $dates_animaux, $date_fin),
            'stock_disponible' => $stock_disponible,
            'stock_vidé' => $stock_vidé,
            'animaux_nourris' => $nb_animaux_nourris
        ];
    }

    private function initialiserDatesRepas($animaux, $date_debut)
    {
        $dates_animaux = [];
        foreach ($animaux as $animal) {
            $dates_animaux[$animal['id_animal']] = $date_debut;
        }
        return $dates_animaux;
    }

    private function trierAnimauxParProximiteVente($animal1, $animal2)
    {
        return abs($animal1['poids_initial'] - $animal1['poids_min_vente']) <=> abs($animal2['poids_initial'] - $animal2['poids_min_vente']);
    }

    
    private function traiterAnimal(&$animal, $type, &$dates_animaux, &$stock_disponible, $date_actuelle, &$nb_animaux_nourris, &$stock_vidé)
{
    $dernier_repas = $dates_animaux[$animal['id_animal']];
    $jours_sans_manger = (strtotime($date_actuelle) - strtotime($dernier_repas)) / 86400;

    if ($jours_sans_manger > $type['nb_jour_sans_manger']) {
        $animal['statut'] = "Mort";
        return;
    }

    if ($animal['auto_vente'] == 1 && $animal['poids_initial'] >= $type['poids_min_vente']) {
        $animal['statut'] = "Vente";
        return;
    }

    // Suppression de la vérification de la date du dernier repas
    // pour permettre de nourrir plusieurs animaux le même jour

    if ($stock_disponible >= $type['quota']) {
        $animal['poids_initial'] += $type['gain'];
        $stock_disponible -= $type['quota'];
        $dates_animaux[$animal['id_animal']] = $date_actuelle; // Mise à jour de la date du dernier repas

        if (!isset($animal['déjà_nourri'])) {
            $nb_animaux_nourris++;
            $animal['déjà_nourri'] = true;
        }
    } else {
        $animal['poids_initial'] -= ($animal['poids_initial'] * ($type['perte_poids'] / 100));
        if ($stock_vidé === null) {
            $stock_vidé = $date_actuelle;
        }
    }
}

    private function genererSituationAnimaux($animaux, $type, $dates_animaux, $date_fin)
    {
        $situation_animaux = [];
        foreach ($animaux as $animal) {
            $dernier_repas = $dates_animaux[$animal['id_animal']];
            $jours_sans_manger = (strtotime($date_fin) - strtotime($dernier_repas)) / 86400;
            $statut = ($jours_sans_manger > $type['nb_jour_sans_manger']) ? "Mort" : ($animal['statut'] ?? "Vivant");

            $situation_animaux[] = [
                'id_animal' => $animal['id_animal'],
                'animal' => $animal['nom_animal'],
                'image' => $animal['image_animal'],
                'poids_final' => $this->verifPoidsMax($animal['poids_initial'], $animal['poids_maximal']),
                'poids_max' => $animal['poids_maximal'],
                'type_animal' => $type['nom_type'],
                'quota' => $type['quota'],
                'dernier_repas' => $dernier_repas,
                'nombre_sans_manger' => $jours_sans_manger,
                'statut' => $statut
            ];
        }
        return $situation_animaux;
    }
}
