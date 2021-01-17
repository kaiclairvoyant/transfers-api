<?php

namespace App\Services;

class NotificationService
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

    private function notify(): array
    {
        return ['message' => 'Enviado'];
    }
}
