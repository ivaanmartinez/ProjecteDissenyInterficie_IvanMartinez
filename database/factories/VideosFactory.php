<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Video::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
            'published_at' => $this->faker->dateTimeThisYear(), // Esto garantiza que nunca será NULL
            'previous' => $this->faker->optional()->word(),
            'next' => $this->faker->optional()->word(),
            'series_id' => $this->faker->optional()->randomDigit(),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
