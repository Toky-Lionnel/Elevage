<?php

namespace app\models;

use Flight;
use PDO;


class DepotModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function updateArgent($argent) 
    {
        $stmt = $this->db->prepare("UPDATE elevage_Argent SET argent = ?");
        return $stmt->execute([$argent]);
    }

    
    public function getArgent()
    {
        $stmt = $this->db->prepare("SELECT argent FROM elevage_Argent");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['argent'];
    }
    

}


?>