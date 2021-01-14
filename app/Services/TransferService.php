<?php

namespace App\Services;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransferService
{
    public function index(): array
    {
        return Transfer::all()->toArray();
    }

    public function store(array $data): Transfer
    {
        DB::beginTransaction();

        $auth = $this->checkAuthorizationApi($data);

        if (in_array('Autorizado', $auth)) {
            $this->subtractPayerCredit($data['payer_id'], $data['value']);

            $this->addPayeeCredit($data['payee_id'], $data['value']);

            DB::commit();

            $this->notifyReceiver();

            return Transfer::create($data);
        }

        DB::rollBack();

        throw new \Exception('Transferência não autorizada.');
    }

    private function checkAuthorizationApi(array $data): array
    {
        return [
            'message' => 'Autorizado'
        ];
    }

    private function subtractPayerCredit(string $payer_id, int $value): void
    {
        $payer = User::findOrFail($payer_id);

        $newCredit = $payer->credit - $value;

        $payer->update([
            'credit' => $newCredit
        ]);
    }

    private function addPayeeCredit(string $payee_id, int $value): void
    {
        $payee = User::findOrFail($payee_id);

        $newCredit = $payee->credit + $value;

        $payee->update([
            'credit' => $newCredit
        ]);
    }

    private function notifyReceiver(): void
    {
        $message = $this->callNotificationService();

        if (!in_array('Enviado', $message)) {
            report(
                new \Exception('Notificação não enviada')
            );
        }
    }

    private function callNotificationService(): array
    {
        return ['message' => 'Enviado'];
    }
}
