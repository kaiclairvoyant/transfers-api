<?php

namespace App\Interfaces;

interface AuthorizationInterface
{
    public function isAuthorized(): bool;

    public function checkAuthApi(): array;
}
