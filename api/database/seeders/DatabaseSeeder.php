<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Kert Tatoy',
            'email' => 'tatoy.kert.e@gmail.com',
            'password' => 'password',
            'role' => '1',
        ]);

        // $this->call([CategorySeeder::class]);
    }
}
