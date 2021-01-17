<?php

namespace App\Services;

class AuthorizationService
{
    public function isAuthorized(): bool
    {
        $auth = $this->checkAuthApi();

        if (in_array('Autorizado', $auth)) {
            return true;
        }

        return false;
    }

    private function checkAuthApi(): array
    {
        return [
            'message' => 'Autorizado'
        ];
    }
}
