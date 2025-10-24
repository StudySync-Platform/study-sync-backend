<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudySessionFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-2 weeks', '+1 week');
        $end = (clone $start)->modify('+2 hours');

        return [
            'room_id' => Room::inRandomOrder()->first()?->id ?? Room::factory(),
            'host_user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'subject' => $this->faker->randomElement(['Math', 'Physics', 'History']),
            'start_time' => $start,
            'end_time' => $end,
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'cancelled']),
            'visibility' => $this->faker->randomElement(Visibility::cases())->value,
            'room_link' => $this->faker->url(),
            'recording_url' => $this->faker->boolean ? $this->faker->url() : null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (\App\Models\StudySession $session) {
            // Attach 3–5 random users as members
            $users = User::inRandomOrder()->take(rand(3, 5))->pluck('id');
            $session->members()->attach($users);
        });
    }
}
