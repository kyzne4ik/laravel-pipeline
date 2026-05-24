<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'master_class_id' => MasterClass::factory(),
        ];
    }
}
