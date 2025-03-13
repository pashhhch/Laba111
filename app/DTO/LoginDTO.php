<?php

namespace App\DTO;

class LoginDTO
{
    public string $token;
    public string $token_type = 'Bearer';

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
