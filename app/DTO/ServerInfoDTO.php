<?php

namespace App\DTO;

class ServerInfoDTO
{
    public $phpVersion;

    public function __construct($phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
}
