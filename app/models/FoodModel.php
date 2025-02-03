<?php

namespace app\models;

use Flight;
use PDO;


class FoodModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllAliments() {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Alimentation");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}


?>