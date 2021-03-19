<?php

namespace App\Services;

use App\Interfaces\AuthorizationInterface;

class AuthorizationService implements AuthorizationInterface
{
    public function isAuthorized(): bool
    {
        if (in_array('Autorizado', $this->checkAuthApi())) {
            return true;
        }

        return false;
    }

    public function checkAuthApi(): array
    {
        return [
            'message' => 'Autorizado'
        ];
    }
}
