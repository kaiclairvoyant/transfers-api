<?php

namespace App\Services;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransferService
{
    private NotificationService $notificationService;

    private AuthorizationService $authorizationService;

    public function __construct()
    {
        $this->notificationService = app(NotificationService::class);

        $this->authorizationService = app(AuthorizationService::class);
    }

    public function index(): array
    {
        return Transfer::all()->toArray();
    }

    public function store(array $data): Transfer
    {
        $auth = $this->authorizationService->isAuthorized();

        if ($auth) {
            DB::beginTransaction();

            $this->subtractPayerCredit($data['payer_id'], $data['value']);

            $this->addPayeeCredit($data['payee_id'], $data['value']);

            $this->notificationService->sendNotification();

            $transfer = Transfer::create($data);

            DB::commit();

            return $transfer;
        }

        DB::rollBack();

        throw new \Exception('Transferência não autorizada.');
    }

    private function subtractPayerCredit(string $payer_id, int $value): void
    {
        $payer = User::findOrFail($payer_id);

        $payer->update([
            'credit' => $payer->credit - $value
        ]);
    }

    private function addPayeeCredit(string $payee_id, int $value): void
    {
        $payee = User::findOrFail($payee_id);

        $payee->update([
            'credit' => $payee->credit + $value
        ]);
    }
}
