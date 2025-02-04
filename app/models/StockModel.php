<?php

namespace app\models;

use Flight;
use PDO;


class StockModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getStockDetails()
    {
        $stmt = $this->db->prepare("
            SELECT 
                s.id_alimentation, 
                a.nom_aliment, 
                a.image_url, 
                a.gain, 
                a.prix, 
                SUM(s.quantite) AS quantite_totale
            FROM elevage_Stock s
            INNER JOIN elevage_Alimentation a ON s.id_alimentation = a.id_alimentation
            GROUP BY s.id_alimentation, a.nom_aliment, a.image_url, a.gain, a.prix
        ");
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}


?>