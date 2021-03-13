<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionService
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
        return Transaction::all()->toArray();
    }

    public function store(array $data): Transaction
    {
        $auth = $this->authorizationService->isAuthorized();

        if (!$auth) {
            throw new \Exception('Unauthorized', 401);
        }

        try {
            DB::beginTransaction();

            $this->subtractPayerCredit($data['payer_id'], $data['value']);

            $this->addPayeeCredit($data['payee_id'], $data['value']);

            $this->notificationService->sendNotification();

            $transaction = Transaction::create($data);

            DB::commit();

            return $transaction;
        } catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception('Transaction could not be completed', 500);
        }
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
