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

    function calculerPoidsAnimal($id_animal, $date_fin) {
        // Date actuelle (date de début)
        $date_debut = new DateTime('now'); // NOW
        $date_fin = new DateTime($date_fin);
    
        // Vérifier que la date fin est bien dans le passé
        if ($date_fin > $date_debut) {
            return "La date de fin doit être antérieure à aujourd'hui.";
        }
    
 // Récupérer le poids le plus récent AVANT la date de début du calcul
$stmt = $this->db->prepare("
SELECT poids, date_alimentation 
FROM elevage_Historique_Alimentation 
WHERE id_animal = ? AND date_alimentation <= ?
ORDER BY date_alimentation DESC 
LIMIT 1
");
$stmt->execute([$id_animal, $date_fin->format('Y-m-d')]);
$historique = $stmt->fetch(PDO::FETCH_ASSOC);

if ($historique) {
$poids = (float) $historique['poids']; // Poids à la dernière date connue
$dernier_jour_mange = new DateTime($historique['date_alimentation']);
} else {
// Aucun historique, récupérer le poids initial de l'animal
$stmt = $this->db->prepare("
    SELECT poids_initial 
    FROM elevage_Animal 
    WHERE id_animal = ?
");
$stmt->execute([$id_animal]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$animal) {
    return "Animal introuvable.";
}

$poids = (float) $animal['poids_initial']; // Poids initial de l'animal
$dernier_jour_mange = null; // Pas de date d'alimentation connue
}

    
        // Récupérer les informations du type d'animal
        $stmt = $this->db->prepare("
            SELECT eta.perte_poids, ea.gain 
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
        $gain_poids = ($type_animal['gain'] ?? 0) / 100; // Convertir en pourcentage
    
        // Récupérer toutes les dates où l'animal a mangé après la dernière alimentation connue
        $stmt = $this->db->prepare("
            SELECT date_alimentation 
            FROM elevage_Historique_Alimentation 
            WHERE id_animal = ? AND date_alimentation BETWEEN ? AND ?
            ORDER BY date_alimentation ASC
        ");
        $stmt->execute([$id_animal, $date_fin->format('Y-m-d'), $date_debut->format('Y-m-d')]);
        $dates_nourri = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
        // Boucle jour par jour en avançant
        $date_iter = clone $date_fin;
    
        while ($date_iter <= $date_debut) { // Parcours du passé vers aujourd'hui
            $date_str = $date_iter->format('Y-m-d');
    
            if (in_array($date_str, $dates_nourri)) { 
                $poids *= (1 + $gain_poids); // Gain de poids si l'animal mange
            } else {
                $poids *= (1 - $perte_poids); // Perte de poids si l'animal ne mange pas
            }
    
            // Avancer d'un jour
            $date_iter->modify('+1 day');
        }
    
        return round($poids, 2); // Arrondi à deux décimales
    }
    

    function updatePoidsAnimal($id_animal, $poid) {
    // Vérifier que le poids est un nombre valide
    if (!is_numeric($poid) || $poid <= 0) {
        return "Le poids doit être un nombre positif.";
    }

    // Requête SQL pour mettre à jour le poids
    $stmt = $this->db->prepare("
        UPDATE elevage_Animal 
        SET poids_initial = ? 
        WHERE id_animal = ?
    ");

    // Exécuter la requête
    $stmt->execute([$poid, $id_animal]);
}
 


    public function Prix($id_animal, $poid) {
    
        // Récupérer les informations de l'animal et son type
        $stmt = $this->db->prepare("
            SELECT a.en_vente, ta.poids_min_vente, ta.poids_maximal, ta.prix_vente_kg
            FROM elevage_Animal a
            JOIN elevage_Type_Animal ta ON a.id_type_animal = ta.id_type_animal
            WHERE a.id_animal = ?
        ");
        $stmt->execute([$id_animal]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Vérifier si l'animal existe
        if (!$animal) {
            return "Animal introuvable.";
        }
    
        // Vérifier si le poids est dans les limites de vente
        if ($poid < $animal['poids_min_vente'] || $poid > $animal['poids_maximal']) {
            return "Poids non valide pour la vente.";
        }
    
        // Calcul du prix
        $prix = $poid * $animal['prix_vente_kg'];
    
        return round($prix, 2); // Arrondi à 2 décimales
    }

    public function updateDepot($argent) {
        $stmt = $this->db->prepare("UPDATE elevage_Argent SET argent = (argent + ?)");
        return $stmt->execute([$argent]);
    }

    public function mettreEnVente($id_animal) {
        // Vérifier que l'ID de l'animal est valide
        if (!is_numeric($id_animal) || $id_animal <= 0) {
            return "ID animal invalide.";
        }
    
        // Préparer et exécuter la mise à jour de la colonne en_vente
        $stmt = $this->db->prepare("UPDATE elevage_Animal SET en_vente = 0 WHERE id_animal = ?");
        
        $stmt->execute([$id_animal]);
    }
    


}
