<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        User::factory()->create([
            'name' => 'Rodrigo Santorato',
            'email' => 'rodrigo@gmail.com',
            'credit' => '500000',
            'type' => User::TYPE_COMMON,
        ]);

        User::factory()->create([
            'name' => 'Arruda Confeitaria',
            'email' => 'arruda.confeitaria@gmail.com',
            'credit' => '200000',
            'type' => User::TYPE_SHOPKEEPER,
        ]);

        User::factory(8)->create();
    }
}
