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

    
}


?>