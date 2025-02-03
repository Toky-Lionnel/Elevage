<?php

namespace app\models;

use Flight;
use PDO;


class ModifTypeModel
{

    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function getAllTypeAnimal()
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Type_Animal tA JOIN 
        elevage_Alimentation Al ON tA.id_alimentation = Al.id_alimentation ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAlimentation ()
    {
        $stmt = $this->db->prepare("SELECT * FROM elevage_Alimentation");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




}

?>