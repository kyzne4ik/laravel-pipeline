<?php

namespace Database\Factories;

use App\Models\CreativeActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CreativeActivity>
 */
class CreativeActivityFactory extends Factory
{
    protected $model = CreativeActivity::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'image_path' => fake()->imageUrl(),
        ];
    }
}
