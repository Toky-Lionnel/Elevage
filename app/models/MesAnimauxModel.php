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

    function calculerPoidsAnimal($id_animal, $date_debut) {
        // Date actuelle
        $date_actuelle = new DateTime();
        $date_debut = new DateTime($date_debut);
    
        // Récupérer le poids initial de l'animal à la date donnée
        $stmt = $this->db->prepare("
            SELECT poids 
            FROM elevage_Historique_Alimentation 
            WHERE id_animal = ? AND date_alimentation <= ?
            ORDER BY date_alimentation DESC 
            LIMIT 1
        ");
        $stmt->execute([$id_animal, $date_debut->format('Y-m-d')]);
        $poids_initial = $stmt->fetchColumn();
    
        if (!$poids_initial) {
            return "Aucun enregistrement de poids trouvé pour cet animal.";
        }
    
        // Récupérer le type d'animal et ses informations
        $stmt = $$this->db->prepare("
            SELECT eta.perte_poids, eta.nb_jour_sans_manger, ea.gain 
            FROM elevage_Animal a
            JOIN elevage_Type_Animal eta ON a.id_type_animal = eta.id_type_animal
            LEFT JOIN elevage_Alimentation ea ON eta.id_alimentation = ea.id_alimentation
            WHERE a.id_animal = ?
        ");
        $stmt->execute([$id_animal]);
        $type_animal = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$type_animal) {
            return "Informations du type d'animal introuvables.";
        }
    
        $perte_poids = $type_animal['perte_poids'] / 100; // Convertir en pourcentage
        $nb_jour_sans_manger = $type_animal['nb_jour_sans_manger'];
        $gain_poids = ($type_animal['gain'] ?? 0) / 100; // Convertir en pourcentage
    
        // Récupérer les jours où l'animal a été nourri
        $stmt = $this->db->prepare("
            SELECT date_alimentation 
            FROM elevage_Historique_Alimentation 
            WHERE id_animal = ? AND date_alimentation BETWEEN ? AND ?
        ");
        $stmt->execute([$id_animal, $date_debut->format('Y-m-d'), $date_actuelle->format('Y-m-d')]);
        $dates_nourri = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
        $poids = $poids_initial;
        $jours_sans_manger = 0;
        $date_iter = clone $date_debut;
    
        while ($date_iter <= $date_actuelle) {
            $date_str = $date_iter->format('Y-m-d');
    
            if (in_array($date_str, $dates_nourri)) {
                $poids *= (1 + $gain_poids);
                $jours_sans_manger = 0; // Reset du compteur de jours sans manger
            } else {
                $jours_sans_manger++;
                if ($jours_sans_manger > $nb_jour_sans_manger) {
                    $poids *= (1 - $perte_poids);
                }
            }
            
            // Passer au jour suivant
            $date_iter->modify('+1 day');
        }
    
        return round($poids, 2); // Arrondi à deux décimales
    }
    
    
    

}
