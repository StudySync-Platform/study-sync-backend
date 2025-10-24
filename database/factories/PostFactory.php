<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
use App\Models\User;
use App\Models\Room;
use App\Enums\Visibility;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'room_id' => Room::inRandomOrder()->first()?->id ?? null, // sometimes null
            'content' => $this->faker->paragraphs(2, true),
            'media_urls' => [$this->faker->imageUrl()],
            'visibility' => $this->faker->randomElement(Visibility::cases())->value,
            'type' => $this->faker->randomElement(['text', 'image', 'video', 'link']),
        ];
    }
}
