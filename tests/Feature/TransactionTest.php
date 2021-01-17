<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function testItTransfersMoneyWithTheCorrectInput()
    {
        $payer = User::factory()->create([
            'type' => User::TYPE_COMMON
        ]);

        $payee = User::factory()->create([
            'type' => User::TYPE_SHOPKEEPER
        ]);

        $value = 30000;

        $response = $this->postJson(
            'api/transaction',
            [
                'value'    => $value,
                'payer_id' => $payer->id,
                'payee_id' => $payee->id
            ]
        );

        $response->assertStatus(Response::HTTP_CREATED);

        $transaction = [
            "value"    => $value,
            "payer_id" => $payer->id,
            "payee_id" => $payee->id,
            "id"       => $response->json('id'),
        ];

        $response->assertJson($transaction);

        $this->assertEquals(
            $payer->credit - $value,
            $payer->refresh()->credit
        );

        $this->assertEquals(
            $payee->credit + $value,
            $payee->refresh()->credit
        );

        $this->assertDatabaseHas('transactions', $transaction);
    }
}
