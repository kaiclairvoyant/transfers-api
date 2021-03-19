<?php

namespace App\Services;

use App\Interfaces\NotificationInterface;

class NotificationService implements NotificationInterface
{
    public function sendNotification(): void
    {
        $message = $this->notify();

        if (!in_array('Enviado', $message)) {
            report(
                new \Exception('Notificação não enviada')
            );
        }
    }

    public function notify(): array
    {
        return ['message' => 'Enviado'];
    }
}
