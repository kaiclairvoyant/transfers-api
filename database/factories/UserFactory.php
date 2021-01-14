<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'credit' => $this->faker->numberBetween(100000, 1000000),
            'document' => $this->faker->unique('', 100)->randomNumber(8),
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => $this->faker->password,
            'type' => $this->faker->randomElement([
                User::TYPE_COMMON,
                User::TYPE_SHOPKEEPER,
            ]),
        ];
    }
}
