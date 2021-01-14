<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TransferRequestTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testShopkeepersCantMakeTransfers()
    {
        $payer = User::factory()->create([
            'type' => User::TYPE_SHOPKEEPER
        ]);

        $payee = User::factory()->create();

        $response = $this->postJson(
            'api/transfers',
            [
                'value' => $this->faker->randomNumber(6),
                'payer_id' => $payer->id,
                'payee_id' => $payee->id
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertSee('Invalid user type.');
    }
}
