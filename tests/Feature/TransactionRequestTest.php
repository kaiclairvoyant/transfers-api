<?php

namespace Tests\Feature;

use App\Http\Request\TransactionRequest;
use App\Models\User;
use App\Rules\PayerRule;
use App\Rules\TransferValueRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TransactionRequestTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testShopkeepersCannotMakeTransfers()
    {
        $payer = User::factory()->create([
            'type' => User::TYPE_SHOPKEEPER
        ]);

        $payee = User::factory()->create();

        $response = $this->postJson(
            'api/transaction',
            [
                'value' => $this->faker->randomNumber(6),
                'payer_id' => $payer->id,
                'payee_id' => $payee->id
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertSee('Invalid user type.');
    }

    public function testPayerMustHaveSufficientCredit()
    {
        $payer = User::factory()->create([
            'credit' => 10000,
            'type' => User::TYPE_COMMON
        ]);

        $payee = User::factory()->create();

        $response = $this->postJson(
            'api/transaction',
            [
                'value' => 20000,
                'payer_id' => $payer->id,
                'payee_id' => $payee->id
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertSee('Insufficient credit.');
    }

    public function testValidationsAreCorrect()
    {
        $this->assertEquals(
            [
                'value' => [
                    'required',
                    'integer',
                    new TransferValueRule()
                ],
                'payer_id' => [
                    'required',
                    'integer',
                    new PayerRule()
                ],
                'payee_id' => 'required|integer|exists:users,id',
            ],
            (new TransactionRequest())->rules()
        );
    }
}
