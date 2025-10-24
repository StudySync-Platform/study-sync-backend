<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudySession;

class StudySessionSeeder extends Seeder
{
    public function run(): void
    {
        StudySession::factory()->count(10)->create();
    }
}
