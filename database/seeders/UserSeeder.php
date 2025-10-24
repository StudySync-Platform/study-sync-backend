<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'aya@example.com', // only unique identifiers should go here
            ],
            [
                'first_name' => 'Aya',
                'last_name' => 'Test',
                'password' => Hash::make('secret123'),
            ]
        );

        \App\Models\User::factory(10)->create();
    }
}
