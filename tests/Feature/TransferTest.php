<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TransferTest extends TestCase
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
            'api/transfers',
            [
                'value' => $value,
                'payer_id' => $payer->id,
                'payee_id' => $payee->id
            ]
        );

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJson([
            "value" => $value,
            "payer_id" => $payer->id,
            "payee_id" => $payee->id,
            "id" => $response->json('id'),
        ]);

        $this->assertEquals(
            $payer->credit - $value,
            $payer->refresh()->credit
        );

        $this->assertEquals(
            $payee->credit + $value,
            $payee->refresh()->credit
        );
    }
}
