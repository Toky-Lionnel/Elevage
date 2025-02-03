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
}

?>