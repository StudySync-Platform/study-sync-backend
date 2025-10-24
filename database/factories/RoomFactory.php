<?php

namespace Database\Factories;

use App\Enums\Visibility;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'subject' => $this->faker->randomElement(['Math', 'Biology', 'Chemistry']),
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'host_user_id' => User::factory(),
            'max_members' => $this->faker->numberBetween(5, 20),
            'visibility' => $this->faker->randomElement(Visibility::cases())->value,
            'thumbnail_url' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(['active', 'archived', 'full']),
        ];
    }
}
