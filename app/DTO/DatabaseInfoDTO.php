<?php
// app/DTO/DatabaseInfoDTO.php
namespace App\DTO;

class DatabaseInfoDTO
{
    public $database_name;

    public function __construct($databaseName)
    {
        $this->database_name = $databaseName;
    }
}

