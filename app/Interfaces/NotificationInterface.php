<?php

namespace App\Interfaces;

interface NotificationInterface
{
    public function sendNotification(): void;

    public function notify(): array;
}
