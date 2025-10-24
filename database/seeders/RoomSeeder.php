<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\User;
use App\Enums\Visibility;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::factory()->count(5)->create();
    }
}
