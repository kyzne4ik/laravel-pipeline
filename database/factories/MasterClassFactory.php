<?php

namespace Database\Factories;

use App\Models\CreativeActivity;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MasterClass>
 */
class MasterClassFactory extends Factory
{
    protected $model = MasterClass::class;

    public function definition(): array
    {
        return [
            'instructor_id' => User::factory()->instructor(),
            'activity_id' => CreativeActivity::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'date' => fake()->unique()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'time_slot' => fake()->randomElement(['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00']),
            'capacity' => fake()->numberBetween(5, 20),
            'cost' => fake()->randomFloat(2, 10, 100),
        ];
    }
}
