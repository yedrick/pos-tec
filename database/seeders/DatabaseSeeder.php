<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'yerfe717@gmail.com'],
            [
                'name' => 'Yerson Jarandilla',
                'password' => Hash::make('12345678'),
            ]
        );

        $this->call(ProductoSeeder::class);
    }
}
